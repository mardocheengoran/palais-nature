<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        //dd(request()->serverMemo['data']['state']['image']);
        //dd($input['image']);
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'required|max:255',

            'image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],

        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'first_name' => $input['first_name'],
                'email' => $input['email'],
                'sex' => $input['sex'],
                'phone' => $input['phone'],
            ])->save();
        }

        if(isset($input['image']))
        {
            $media = $user->getMedia('image');
            if (count($media)) {
                $media[0]->delete();
            }
            $extension = $input['image']->getClientOriginalExtension();
            $name = $user->slug.'.'.$extension;
            //$name = generate_file_name($user->slug, 'image');
            $user->addMedia($input['image']->getRealPath())
            ->usingFileName($name)
            ->toMediaCollection('image');
        }
        session()->flash('message', 'Compte mise à jour avec succès ;-');
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
