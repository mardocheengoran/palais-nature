<?php

namespace App\Http\Livewire;

use Exception;
use GuzzleHttp\Client;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\CreateContact;

class Newsletter extends Component
{
    use LivewireAlert;

    public $email;

    public function render()
    {
        return view('livewire.newsletter');
    }

    public function send($sex)
    {
        //dd($sex);
        $this->validate([
            'email' => 'required|email',
        ]);

        // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');
        // Configure API key authorization: partner-key
        $apiInstance = new ContactsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );

        $createContact = new CreateContact(); // Values to create a contact
        $createContact['email'] = $this->email;
        $createContact['listIds'] = [$sex];
        //dd($createContact);

        try {
            $result = $apiInstance->createContact($createContact);
            //dd($result);
            $this->alert('success', 'Souscription à la newsletter effectuée avec succès', [
                'position' => 'top-end',
                'timer' => 10000,
                'toast' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Fermer',
                'onDismissed' => '',
                'timerProgressBar' => true,
            ]);
        } catch (Exception $e) {
            //dd($e->getCode());
            switch ($e->getCode()) {
                case 400:
                    $message = 'Vous êtes déjà inscrit à la newsletter';
                    break;

                default:
                    $message = 'Erreur : '.$e->getMessage();
                    break;
            }
            $this->alert('warning', $message, [
                'position' => 'top-end',
                'timer' => 10000,
                'toast' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Fermer',
                'onDismissed' => '',
                'timerProgressBar' => true,
            ]);
        }

        /* $this->alert('success', 'Souscription effectuée avec succès', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Fermer',
            'onDismissed' => '',
            'timerProgressBar' => true,
        ]); */

        //$this->email = null;
    }
}
