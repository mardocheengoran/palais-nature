<x-filament::page class="filament-user-view">

 <div class="w-full ">
    <div class="flex gap-4 ">
        <div class=" shadow-lg w-[25%] rounded-lg ">

            <div class=" shadow-lg relative gap-2 px-2 py-4 bg-white ">
                <div class=" rounded-xl p-8">
                    <img class="rounded-full mx-auto" width="150" height="150" src="https://www.freeiconspng.com/uploads/account-profile-icon-1.png" width="350" alt="account profile icon">
                </div>
                <div class="">
                    <li class="flex items-center">
                        <div class="bg-cyan-250 rounded-full p-2 fill-current text-cyan-700 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                          </div>
                          <span class="text-gray-700 text-lg ml-3">{{ $record->name }}</span>
                        </li> <br>



                </div>
            <div>


                <li class="flex items-center">

                    <div class="bg-cyan-250 rounded-full p-2 fill-current text-cyan-700 ">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-gray-700 text-lg ml-3">{{ $record->email }}</span>
                  </li> <br>


            </div>
                <div>
                    <li class="flex items-center ">
                        <div class="bg-cyan-250 rounded-full p-2 fill-current text-cyan-700">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 text-lg ml-3">{{ $record->phone }}</span>
                      </li> <br>

                </div>

                <div>
                    <li class="flex items-center">
                        <div class="bg-cyan-250 rounded-full p-2 fill-current text-cyan-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                              </svg>
                        </div>
                        <span class=" text-gray-700 text-lg ml-3">
                        a rejoint {{$record->created_at->diffForHumans()}}
                       </span>
                      </li> <br>
                </div>

                 <div>
                        <li class="flex items-center">
                            <div class="bg-cyan-250 rounded-full p-2 fill-current text-cyan-700">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <b> <span class=" text-gray-700 text-lg ml-3">

                              @foreach ($record->roles as $role)
                              {{$role->name}}
                          @endforeach

                           </span>
                          </b>
                          </li> <br>

                    </div>



            </div>

        </div>

        <div class="shadow-lg w-[75%] h-[75%] bg-white rounded-lg">
            <div class="grid grid-cols-4 gap-6 py-4 px-4">
                <div class="">
                    <b> Comission : </b>
                    @foreach ($record->committees as $comitty)

                        <span class=" text-cyan-700 text-lg ml-3">
                             <b>
                            {{$comitty->title}}
                            </b>
                            <br>
                        </span>

                    @endforeach
                </div>

                <div>
                    <b> Type de commission : </b>
                    @foreach ($record->committees as $comitty)

                    <span class=" text-cyan-700 text-lg ml-3">
                         <b>
                        {{$comitty->typeCommittee->title}}
                        </b>
                        <br>
                    </span>

                @endforeach
                </div>

                <div>
                    <b> Budget proposé : </b> <br>
                    @foreach ($record->committees as $comitty)

                    <span class=" text-cyan-700 text-lg ml-3">
                         <b>
                        {{devise($comitty->amount_propose)}}
                        </b>
                        <br>
                    </span>

                @endforeach
                </div>

                <div>
                    <b> Budget validé : </b> <br>
                    @foreach ($record->committees as $comitty)

                    <span class=" text-cyan-700 text-lg ml-3">
                         <b>
                        {{ devise($comitty->amount_valid)}}
                        </b>
                        <br>
                    </span>

                @endforeach
                </div>

            </div>
        </div>
    </div>

 </div>
</x-filament::page>
