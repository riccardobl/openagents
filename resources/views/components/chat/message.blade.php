<div class="z-[-1] w-full text-lightgray">
    <div class="px-1 py-2 justify-center text-base md:gap-6 m-auto">
        <div
                class="flex flex-1 text-base mx-auto gap-3 md:px-5 lg:px-1 xl:px-5 md:max-w-3xl lg:max-w-[800px]">
            <div class="flex-shrink-0 flex flex-col relative items-end">
                @if ($author === 'You')
                    <div class="m-[2px] w-[28px] p-[2px] border border-darkgray rounded">
                        <x-icon name="user" class=""/>
                    </div>
                @else

                    <!-- if the message author is agent, show their image here -->
                    @if ($agentImage)
                        <div class="m-[1px] w-[28px] p-[2px] border border-darkgray rounded">
                            <img src="{{ $agentImage }}" alt="Agent Image">
                        </div>
                    @elseif ($modelImage)
                        <div class="m-[1px] w-[28px] p-[2px] ">
                            <img src="{{ $modelImage }}" alt="Model Image">
                        </div>
                    @else
                        <div class="m-[1px] w-[28px] p-[5px] border border-darkgray rounded">
                            <x-icon name="logo" class=""/>
                        </div>
                    @endif

                @endif
            </div>
            <div class="relative flex w-full flex-col">
                <span class="mb-1 font-semibold select-none text-white">{{ $author }}</span>
                <div class="flex-col gap-1 md:gap-3">
                    <div class="-mt-4 flex flex-grow flex-col max-w-[936px]">

                        @if(substr($message, 0, 11) === 'data:image/')
                            <img class="mt-6" src="{{ $message }}" alt="Embedded Image">
                        @else
                            <x-markdown
                                    class="text-md text-text markdown-content {{ $promptClass }}">{!! $message !!}</x-markdown>
                            <div class="dot-flashing opacity-0"></div>
                        @endif

                    </div>
                    <div class="flex justify-start gap-3 empty:hidden">
                        <div class="text-gray flex self-end lg:self-center justify-center lg:justify-start mt-0 -ml-1 h-7 visible">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
