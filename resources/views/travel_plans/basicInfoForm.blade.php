<div class="space-y-4">
    <div>
        <x-input-label for="title" value="プラン名" />
        <x-text-input id="title" type="text" 
            name="title" value="{{ old('title', $travelPlan->title ?? '') }}" 
            required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="country" value="国" />
        <x-text-input id="country" type="text"
            name="country" value="{{ old('country', $travelPlan->country ?? '') }}" 
            required/>
        <x-input-error :messages="$errors->get('country')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="city" value="都市" />
        <x-text-input id="city" type="text"
            name="city" value="{{ old('city', $travelPlan->city ?? '') }}" 
            required/>
        <x-input-error :messages="$errors->get('city')" class="mt-2" />
    </div>

    <div>
        <div class="block font-medium text-sm">旅行期間</div>
        <div class="pl-4 flex">
            <div>
                <x-input-label for="start_date" value="開始日" />
                <x-text-input id="start_date" type="date"
                    name="start_date" value="{{ old('start_date', $travelPlan->start_date ?? '') }}" 
                    required/>
                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
            </div>
            <div class="pl-4">
                <x-input-label for="end_date" value="終了日" />
                <x-text-input id="end_date" type="date"
                    name="end_date" value="{{ old('end_date', $travelPlan->end_date ?? '') }}" 
                    required/>
                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
            </div>
        </div>
    </div>

    <div>
        <x-input-label for="overview" value="概要" />
        <x-textarea id="overview" type="text" row="4" class="mt-1 block w-full lg:w-1/2"
            name="overview" >{{ old('overview', $travelPlan->overview ?? '') }}</x-textarea>
        <x-input-error :messages="$errors->get('overview')" class="mt-2" />
    </div>
    
    <div>
        <x-input-label for="photo_url" value="写真" />
        <x-text-input id="photo_url" name="photo_url" value="{{ old('photo_url', $travelPlan->photo_url ?? '') }}" type="file" class="mt-1 block w-auto"/>
        <img id="photo_preview" 
            src="{{ isset($travelPlan) && $travelPlan->photo_url 
                ? asset('storage/photos/' . $travelPlan->photo_url) 
                : asset('images/default_photo.png') }}" 
                alt="サムネイル" 
                class="mt-2 w-80 h-60 object-cover">
        
        <x-input-error class="mt-2" :messages="$errors->get('photo_url')" />
    </div>

    <script>
        document.getElementById('photo_url').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('photo_preview');

            if(file) {
                preview.src = URL.createObjectURL(file);
            } else {
                preview.src = "{{ isset($travelPlan) && $travelPlan->photo_url ? asset('storage/photos/' . $travelPlan->photo_url) : asset('images/default_photo.png') }}";
            }
        });
    </script>

    <div>
        <x-input-label value="ステータス" />
        <div class="pl-4 flex space-x-4">
            <div class="flex">
                <input type="radio" id="status_planned" name="status" 
                        value="planned" 
                        {{ old('status', $travelPlan->status ?? 'planned') === 'planned' ? 'checked' : '' }} >
                <x-input-label for="status_planned" value="予定" />
            </div>
            <div class="flex">
                <input type="radio" id="status_completed" name="status" 
                        value="completed" 
                        {{ old('status', $travelPlan->status ?? '') === 'completed' ? 'checked' : '' }} >
                <x-input-label for="status_completed" value="完了" />
            </div>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    </div>

    <div>
        <div class="flex">
            <input type="checkbox" id="is_public" name="is_public" 
                value="1"
                {{ old('is_public', $travelPlan->is_public ?? false) ? 'checked' : '' }} >
            <x-input-label for="is_public" value="公開する"/>
        </div>
        <x-input-error :messages="$errors->get('is_public')" class="mt-2" />
    </div>
</div>