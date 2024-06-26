<div>
    {{-- Care about people's approval and you will be their prisoner. --}}


    <div class="mt-10 p-5 y-5 mx-auto w-full max-w-5xl md:max-w-[800px]">
        <div class="flex flex-col md:flex-row md:items-center md:gap-4 border-b py-4">
            <div class="order-2 flex-1">
                <h1 class="text-[25px] md:text-xl font-bold">{{ $plugin->name }}</h1>
                <h5 class="text-sm font-semibold">Edit plugin</h5>
            </div>
            <a href="{{ route('plugins.index') }}" wire:navigate class="order-1 mb-4 md:mb-0 md:text-left">
                <h3 class="text-[16px] text-gray">&larr; Back</h3>
            </a>
        </div>
        {{-- <h1 class="text-md md:text-3xl font-bold my-6 md:mb-10 text-center">Create a plugin</h1> --}}
        <div class="my-5 mx-auto max-w-5xl">
            <form wire:submit.prevent="submit">
                <div class="mt-5">
                    <label for="name">Name</label>
                    <x-input id="name" class="block mt-1 w-full " type="text" name="name" wire:model='name'
                        dusk="name" placeholder="Name your plugin" />
                    @error('name')
                        <span class="text-red mt-2 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="about">Description</label>
                    <x-textarea wire:model='description'
                        placeholder="Add a short description about what this plugin does" id="about"
                        class="block mt-1 w-full" dusk="description" min-rows="3" name="about" />
                    @error('about')
                        <span class="text-red mt-2 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="web">Website</label>
                    <x-input id="web" class="block mt-1 w-full " type="text" name="web" wire:model='web'
                        dusk="web" placeholder="Youe plugin website" />
                    @error('web')
                        <span class="text-red mt-2 text-xs">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mt-5">
                    <label for="privacy">Privacy</label>
                    <x-input id="privacy" class="block mt-1 w-full " type="text" name="privacy"
                        wire:model='privacy' dusk="privacy" placeholder="Your plugin privacy policy" />
                    @error('privacy')
                        <span class="text-red mt-2 text-xs">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mt-5">
                    <label for="tos">Tos</label>
                    <x-input id="tos" class="block mt-1 w-full " type="text" name="tos" wire:model='tos'
                        dusk="tos" placeholder="Name your plugin" />
                    @error('name')
                        <span class="text-red mt-2 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="mt-5">
                    <label for="file_link">File Url</label>
                    <x-input id="file_link" class="block mt-1 w-full " type="url" name="web"
                        wire:model='file_link' dusk="web" placeholder="Url to the wasm file" />
                    @error('file_link')
                        <span class="text-red mt-2 text-xs">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div class="mt-5 select-none">
                    <label for="files">WASM File</label>
                    <div class="mt-1 border-2 border-darkgray rounded-md">
                        @error('files.*')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <x-filepond ref="wasmFile" wire:model="wasm_upload" allowFileTypeValidation
                            imagePreviewMaxHeight="300"
                            acceptedFileTypes="['application/wasm']"
                            fileValidateTypeLabelExpectedTypesMap="{{ json_encode([
                                'application/wasm' => '.wasm',
                            ]) }}"
                            allowFileSizeValidation maxFileSize="10MB" />
                    </div>
                </div>

                <div class="my-5">
                    <label for="tags">Tags</label>
                    <x-tags-input wire:model='tags' name="tags" :tags="[]" />
                    @error('tags')
                        <span class="text-red mt-2 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div
                    class="border-b border-t font-bold rounded border-gray mt-6 sm:mt-10 mb-4 p-2 col-span-full text-center">
                    Inputs
                </div>

                <div class="w-full">
                    @foreach ($inputs as $key => $input)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-2">
                            <div class="w-full my-6 col-span-full">
                                <label for="input_{{ $key }}_name">Input Name</label>
                                <x-input type="text" id="input_{{ $key }}_name"
                                    wire:model="inputs.{{ $key }}.name" class="block mt-1 w-full "
                                    placeholder="name of the input" autocomplete="off" />
                                @error('inputs.' . $key . '.name')
                                    <span class="text-xs text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="my-5 rounded flex items-center p-1 col-span-full md:col-span-3">
                                <x-switch class="w-full" label="Required" description="Make input required"
                                    wire:model='inputs.{{ $key }}.required' />
                                @error('inputs.' . $key . '.required')
                                    <span class="text-red mt-2 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="my-5 flex items-center  rounded p-1 col-span-full md:col-span-3">
                                <select wire:model='inputs.{{ $key }}.type'
                                    class="w-full border-darkgray bg-black text-white focus:border-white focus:ring-white rounded-md shadow-sm">

                                    <option value="">Select input type</option>
                                    <option value="string">String</option>
                                    <option value="integer">Integer</option>
                                    <option value="array">Array</option>
                                    <option value="json">Json</option>
                                </select>
                                @error('inputs.' . $key . '.type')
                                    <span class="text-xs text-red">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="mt-5 col-span-full">
                                <label for="about">Description</label>
                                <x-textarea wire:model='inputs.{{ $key }}.description'
                                    placeholder="A description about this input" id="about"
                                    class="block mt-1 w-full" dusk="description" min-rows="3" name="about" />
                                @error('inputs.' . $key . '.description')
                                    <span class="text-xs text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($key > 0)
                                <div class="border-b rounded border-gray p-2 col-span-full">
                                    <div wire:click="removeInput({{ $key }})"
                                        class="flex items-center justify-end text-red text-sm w-full cursor-pointer">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <p> Remove</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <div wire:click="addInput"
                        class="flex items-center justify-center text-white text-sm py-4 w-full cursor-pointer">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="ml-2">Add New Input</p>
                    </div>
                </div>


                <div
                    class="border-b border-t font-bold rounded border-gray mt-6 sm:mt-10 mb-4 p-2 col-span-full text-center">
                    Secrets
                </div>

                <div class="w-full">
                    @foreach ($secrets as $key => $secret)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-2">
                            <div class="w-full my-6 col-span-full">
                                <label for="secret_{{ $key }}_key">Key</label>
                                <x-input type="text" id="secret_{{ $key }}_key"
                                    wire:model="secrets.{{ $key }}.key" class="block mt-1 w-full "
                                    placeholder="name of the key i.e api_key,apikey etc" autocomplete="off" />
                                @error('secrets.' . $key . '.key')
                                    <span class="text-xs text-red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mt-5 col-span-full">
                                <label for="about">Secret Value</label>
                                <x-textarea wire:model='secrets.{{ $key }}.value'
                                    placeholder="the value to be used for the key" id="34rrty"
                                    class="block mt-1 w-full" dusk="description" min-rows="3" name="secrets" />
                                @error('secrets.' . $key . '.value')
                                    <span class="text-xs text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($key > 0)
                                <div class="border-b rounded border-gray p-2 col-span-full">
                                    <div wire:click="removeSecretInput({{ $key }})"
                                        class="flex items-center justify-end text-red text-sm w-full cursor-pointer">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <p> Remove</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <div wire:click="addSecretInput"
                        class="flex items-center justify-center text-white text-sm py-4 w-full cursor-pointer">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="ml-2">Add Secret</p>
                    </div>
                </div>


                <div class="border-b border-t font-bold rounded border-gray p-2 my-4 col-span-full text-center">
                    Existism plugin input
                </div>

                <div class="mt-5 col-span-full">
                    <label for="about">Plugin Input</label>
                    {{-- <x-textarea wire:model='plugin_input'
                        placeholder='{{ '{' }}text{{ '}' }}: {{ '{' }}{in.text}}{{ '}' }}, {{ '{' }}to{{ '}' }}: {{ '{' }}{in.target_lang}}{{ '}' }}, {{ '{' }}api_key{{ '}' }}: "%secret.api_key%"'
                        id="34rqwerrty" class="block mt-1 w-full" dusk="description" min-rows="3"
                        name="plugin_input" /> --}}
                    <textarea wire:model='plugin_input'
                        class="block mt-1 w-full resize-none flex w-full rounded-md border-2 bg-transparent px-3 py-[0.65rem] pr-10 text-[16px] placeholder:text-[#777A81] focus-visible:outline-none focus-visible:ring-0 focus-visible:border-white focus-visible:ring-white transition-all duration-300 ease-in-out"
                        dusk="description" min-rows="3">
                        </textarea>
                    @error('plugin_input')
                        <span class="text-xs text-red">{{ $message }}</span>
                    @enderror
                </div>



                <div class="border-b border-t font-bold rounded border-gray p-2 my-4 col-span-full text-center">
                    Outputs
                </div>


                <div class="my-5 flex items-center  rounded p-1 col-span-full">
                    <select wire:model='output_type'
                        class="w-full border-darkgray bg-black text-white focus:border-white focus:ring-white rounded-md shadow-sm">

                        <option value="">Select output type</option>
                        <option value="string">String</option>
                        <option value="integer">Integer</option>
                        <option value="array">Array</option>
                        <option value="json">Json</option>
                    </select>
                    @error('output_type')
                        <span class="text-xs text-red">{{ $message }}</span>
                    @enderror

                </div>

                <div class="mt-5 col-span-full">
                    <label for="about">Description</label>
                    <x-textarea wire:model='output_description' placeholder="A description about this output"
                        id="output_description" class="block mt-1 w-full" dusk="description" min-rows="3"
                        name="about" />
                    @error('output_description')
                        <span class="text-xs text-red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="border-b border-t font-bold rounded border-gray p-2 my-4 col-span-full text-center">
                    Author Info
                </div>


                <div class="mt-5">
                    <label for="author">Author</label>
                    <x-input id="author" class="block mt-1 w-full " type="text" name="author"
                        wire:model='author' dusk="author" placeholder="Name of plugin author" />
                    @error('author')
                        <span class="text-red mt-2 text-xs">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mt-5">
                    <label for="payment">Payment</label>
                    <x-input id="name" class="block mt-1 w-full " type="text" name="payment"
                        wire:model='payment' dusk="payment" placeholder="Bitcoin lightning address" />
                    @error('payment')
                        <span class="text-red mt-2 text-xs">{{ $message }}</span>
                    @enderror
                </div>




                <div class="mt-5 w-full text-center">
                    <x-button type="submit" class="text-center justify-center gap-2 py-2 my-4"
                        dusk="create-plugin-button">
                        Update Plugin
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
