
<div id="pos-customers" x-data="{ openTab: 1, activeClasses:'shadow bg-white text-gray-800', inactiveClasses:'focus:bg-gray-500 text-white hover:text-white' }" class="shadow-lg rounded flex flex-col overflow-hidden w-full" x-cloak>
    <div class="ns-header p-2 flex justify-between items-center border-b">
        <h3 class="font-semibold">{{ __( 'Customers' ) }}</h3>
        <div>
            <span class="border-2 p-1 rounded-full cursor-pointer hover:bg-gray-50 hover:text-black" id="userModalclose" onclick="userModalClosefun()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </span>
        </div>
    </div>
    <ul class="pt-2 px-2 flex flex-row">
        <li  class="" @click=" openTab = 1 ">
            <a  :class="openTab === 1 ? activeClasses : inactiveClasses" class="inline-block cursor-pointer text-gray-900 bg-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-2 px-4 text-md font-medium text-center border-transparent border-b-2" >{{ __('Create a customer') }}</a>
        </li>
        <li  class="" @click=" openTab = 2 ">
            <a :class="openTab === 2 ? activeClasses : inactiveClasses" class="inline-block cursor-pointer text-gray-900 bg-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-2 px-4 text-md font-medium text-center border-transparent border-b-2">{{ __( 'Customer Account' ) }}</a>
        </li>
    </ul>
    <div class="p-2 overflow-y-auto">
        <div  x-show="openTab === 1" class="" id="new_customer">
          <div class="w-full">
              <div  class="h-full hidden flex-col w-full flex items-center justify-center text-primary">
                  <i class="lar la-hand-paper ns-icon text-6xl"></i>
                  <h3 class="font-medium text-2xl">{{ __( 'Not Authorized' ) }}</h3>
                  <p>{{ __( 'Creating customers has been explicitly disabled from the settings.' ) }}</p>
              </div>
              <div class="h-full flex-col w-full flex text-primary test_customer">
                  <form id="createPosUserForm">
                      @csrf

                      <div class="py-4">
                          <!-- Name -->
                          <x-input-label for="name" :value="__('Customer Name')" />
                          <div class="flex justify-between rounded-md border-2 bg-indigo-600 border-indigo-600">
                              <x-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus />
                              <x-button>
                                  {{ __('Save Customer') }}
                              </x-button>
                          </div>
                      </div>

                      <div class="bg-green-0 w-max rounded-md py-2 px-4">
                          <x-input-label :value="__('Information Générale')" />
                      </div>
                      <div class="bg-white rounded-md shadow-lg px-4 w-full">
                          <div class="grid grid-cols-2 gap-4 pb-8">
                              <!-- Email Address -->
                              <div class="col-span-1 mt-4">
                                  <x-input-label for="email" :value="__('E-mail')" />

                                  <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  />
                              </div>
                              <!-- First Name -->
                              <div class="col-span-1 mt-4">
                                  <x-input-label for="first_name" :value="__('Nom de famille')" />

                                  <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')"  />
                              </div>
                              <!-- Phone -->
                              <div class="col-span-1 mt-4">
                                  <x-input-label for="phone" :value="__('Téléphone')" />

                                  <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')"  required/>
                              </div>
                              <!-- Genre -->
                              <div class="col-span-1 mt-4">
                                  <x-input-label for="gender" :value="__('Genre')" />

                                  <!-- <x-text-input id="gender" class="block mt-1 w-full" type="number" name="gender" :value="old('gender')"  /> -->
                                  <select name="gender" id="gender" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm" required>
                                      <option value=""></option>
                                      <option value="Particulier">Particulier</option>
                                      <option value="Entreprise">Entreprise</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
        </div>
        <div  x-show="openTab === 2" class="w-full flex flex-col items-center justify-center" id="customer_account">
            <div id="pos-customer-select" class="w-full">
                <div id="header" class="border-b ns-box-header text-center font-semibold text-2xl py-2">
                    <h2>{{ __( 'Select Customer' ) }}</h2>
                </div>
                <div class="relative">
                    <div class="p-2 border-b ns-box-body items-center flex justify-between">
                        <span>{{ __( 'Selected' ) }} : </span>
                        <div class="flex items-center justify-between">
                            <span></span>
                        </div>
                    </div>
                    <div class="p-2 border-b ns-box-body flex justify-between text-primary">
                        <div class="input-group flex-auto border-2 rounded">
                            <input
                                placeholder="{{ __('Search Customer') }}"
                                type="text"
                                class="outline-none w-full p-2 rounded-md border">
                        </div>
                    </div>
                    <div class="h-72 xl:h-2/5 overflow-y-auto">
                        <ul class="vertical-menu">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
