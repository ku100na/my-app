<div class="space-y-4">
    <div>
        <x-input-label for="title" value="プラン名" />
        <x-text-input id="title" type="text" 
            name="email" value="{{ old('title', $travelPlan->title ?? '') }}" 
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
            name="overview" value="{{ old('overview', $travelPlan->overview ?? '') }}" ></x-textarea>
        <x-input-error :messages="$errors->get('overview')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="photo_url" value="画像" />
        <x-text-input id="photo_url" name="icon_image" type="file" class="mt-1 block w-full"/>
        <img id="icon_preview" src="{{ $user->icon_image ? asset('storage/icons/' . $user->icon_image) : asset('images/default_icon.png') }}" alt="プレビュー" class="mt-2 w-24 h-24 object-cover rounded-full">
        
        <x-input-error class="mt-2" :messages="$errors->get('icon_image')" />
    </div>

    <script>
        document.getElementById('icon_image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('icon_preview');

            if(file) {
                preview.src = URL.createObjectURL(file);
            } else {
                preview.src = "{{ $user->icon_image ? asset('storage/icons/' . $user->icon_image) : asset('images/default_icon.png') }}";
            }
        });
    </script>
</div>