<div class="font-bold text-xl text-primary01">旅行後の記録</div>
<div class="pl-4 space-y-4">
    <div>
        <x-input-label value="感想" />
        <x-textarea type="text" name="review" class="w-full">{{ old('review', $travelPlan->travelRecord->review ?? '') }}</x-textarea>
    </div>
    <div>
        <x-input-label value="費用" />
        <x-text-input type="text" id="cost_display" class="text-right" />
        <input type="hidden" name="cost" id="cost" value="{{ old('cost', $travelPlan->travelRecord->cost ?? '') }}"/>
    </div>
</div>
<script>
    const display = document.getElementById('cost_display');
    const hidden = document.getElementById('cost');

    if(hidden.value) {
        display.value = Number(hidden.value).toLocaleString();
    }

    display.addEventListener('input', function() {
        let value = this.value.replace(/[^\d]/g, '');

        hidden.value = value;

        if(!value) {
            this.value = '';
            return;
        }
        this.value = Number(value).toLocaleString();
    });
</script>
