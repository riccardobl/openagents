@props([
    'className' => '',
    'hasError' => false,
    'showIcon' => false,
    'iconName' => '',
    'minRows' => 1,
    'maxRows' => null,
    'default' => '',
])

<div class="relative" x-data="{
    inputVal: '',
    isDisabled: true,
    height: 'auto',
    minRows: @js($minRows),
    maxRows: @js($maxRows),
    viewportMaxHeight: window.innerHeight * 0.95,
    update() {
        this.$refs.textarea.style.height = 'auto';
        let newHeight = this.$refs.textarea.scrollHeight;
        let maxHeight = this.viewportMaxHeight;

        if (this.maxRows !== null) {
            let maxRowsHeight = this.maxRows * this.lineHeight() + this.scrollbarWidth();
            maxHeight = Math.min(maxHeight, maxRowsHeight);
        }

        if (newHeight > maxHeight) {
            this.$refs.textarea.style.height = `${maxHeight}px`;
            this.$refs.textarea.style.overflowY = 'auto';
        } else {
            newHeight = Math.max(newHeight, 48);
            this.$refs.textarea.style.height = `${newHeight}px`;
            this.$refs.textarea.style.overflowY = 'hidden';
        }
    },
    lineHeight() {
        return parseFloat(getComputedStyle(this.$refs.textarea).lineHeight);
    },
    scrollbarWidth() {
        return this.$refs.textarea.offsetWidth - this.$refs.textarea.clientWidth;
    }
}" x-init="update()"
>
<textarea
        x-ref="textarea"
        autocomplete="off"
        spellcheck="false"
        @input="update(); inputVal = $event.target.value; isDisabled = inputVal.length === 0"
        placeholder="{{ $default }}"
        :rows="minRows"
            {{ $attributes->merge([
                'class' => "flex w-full rounded-md border-2 bg-transparent px-3 py-[0.65rem] pr-10 text-[16px] placeholder:text-[#777A81] focus-visible:outline-none focus-visible:ring-0 focus-visible:border-white focus-visible:ring-white " . ($hasError ? 'border-red' : 'border-[#3D3E42]') . " $className transition-all duration-300 ease-in-out",
                'style' => "'resize: none; overflow: hidden;'"
            ]) }}
    ></textarea>

    @if($showIcon && $iconName)
        <button
                :disabled="isDisabled"
                class="absolute bottom-[10px] right-[10px] text-black shadow rounded"
                :class="isDisabled ? 'bg-gray' : 'bg-white hover:bg-white/90'"
        >
            {{-- Assuming <x-icon> is a component you have for rendering icons --}}
            <x-icon :name="$iconName" class="w-[24px] h-[24px] m-0.5 flex flex-col justify-center items-center"/>
        </button>
    @endif
</div>
