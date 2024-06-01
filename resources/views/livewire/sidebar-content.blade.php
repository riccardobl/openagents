<div class="flex flex-col w-full relative z-50 h-full">
    <div class="flex-1 overflow-y-auto">
        <div class="flex flex-col gap-2 py-3 px-1" @thread_updated="$refresh">
            <ol>
                @foreach($threads as $thread)
                    <livewire:sidebar-thread :thread="$thread" :key="$thread->id"/>
                @endforeach
            </ol>
        </div>
    </div>

    <div class="text-gray flex flex-col gap-2 py-1 px-1 mt-auto border-t border-offblack">
        <ol>
            <li>
                <div class="relative z-[15]">
                    <div class="group relative rounded-lg active:opacity-90 px-3">
                        <a class="hover:text-white flex flex-row items-center gap-2 py-1" wire:navigate
                           href="/store">
                            <div class="select-none cursor-pointer relative grow overflow-hidden whitespace-nowrap">
                                Agent Store
                            </div>
                            <div class="text-xs text-gray opacity-50">Beta</div>
                        </a>
                    </div>
                </div>
            </li>
            <li>
                <div class="relative z-[15]">
                    <div class="group relative rounded-lg active:opacity-90 px-3">
                        <a class="flex items-center gap-2 py-1"
                           wire:navigate
                           href="/blog"
                        >
                            <div class="hover:text-white select-none cursor-pointer relative grow overflow-hidden whitespace-nowrap">
                                Blog
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li>
                <div class="relative z-[15]">
                    <div class="group relative rounded-lg active:opacity-90 px-3">
                        <a class="flex items-center gap-2 py-1"
                           wire:navigate
                           href="/changelog"
                        >
                            <div class="hover:text-white select-none cursor-pointer relative grow overflow-hidden whitespace-nowrap">
                                Changelog
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li>
                <div class="relative z-[15]">
                    <div class="group relative rounded-lg active:opacity-90 px-3">
                        <a class="hover:text-white flex flex-row items-center gap-2 py-1" target="_blank"
                           href="https://docs.openagents.com">
                            <div class="select-none cursor-pointer relative grow overflow-hidden whitespace-nowrap">
                                Docs & guides
                            </div>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                        </a>
                    </div>
                </div>
            </li>
            <li>
                <div class="relative z-[15]">
                    <div class="group relative rounded-lg active:opacity-90 px-3">
                        <a class="hover:text-white flex flex-row items-center gap-2 py-1" target="_blank"
                           href="https://stacker.news/~openagents">
                            <div class="select-none cursor-pointer relative grow overflow-hidden whitespace-nowrap">
                                Community
                            </div>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                        </a>
                    </div>
                </div>
            </li>

            <li>
                <div class="relative z-[15]">
                    <div class="group relative rounded-lg active:opacity-90 px-3">
                        <a class="hover:text-white flex flex-row items-center gap-2 py-1" target="_blank"
                           href="https://github.com/OpenAgentsInc/openagents">
                            <div class="select-none cursor-pointer relative grow overflow-hidden whitespace-nowrap">
                                Source code
                            </div>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                        </a>
                    </div>
                </div>
            </li>

            @pro
            <li>
                <div class="relative z-[15]">
                    <div class="group relative rounded-lg active:opacity-90 px-3">
                        <a href="/subscription" target="_blank"
                           class="hover:text-white flex flex-row items-center gap-2 py-1">
                            <div class="relative grow overflow-hidden whitespace-nowrap">
                                Manage subscription
                            </div>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                        </a>
                    </div>
                </div>
            </li>
            @else
                @auth
                    <li>
                        <div class="relative z-[15]">
                            <div class="group relative rounded-lg active:opacity-90 px-3">
                                <a class="flex items-center gap-2 py-1"
                                   wire:click="$dispatch('openModal', { component: 'modals.upgrade' })"
                                >
                                    <div class="select-none cursor-pointer relative grow overflow-hidden whitespace-nowrap">
                                        Upgrade to Pro
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                @endauth
                @endpro
                <li>
                    <div class="relative z-[15]">
                        <div class="flex flex-row group pt-3 px-3 text-gray opacity-75 text-xs">
                            <a href="/terms" class="flex items-center">
                                <div class="relative grow overflow-hidden whitespace-nowrap">
                                    Terms
                                </div>
                            </a> <span class="px-1">&middot;</span>
                            <a href="/privacy" class="flex items-center">
                                <div class="relative grow overflow-hidden whitespace-nowrap">
                                    Privacy
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
        </ol>
    </div>
</div>
