<div class="col-12">
    <div class="row g-3" id="advanced_option">
        <div class="col-md-6">
            <x-form.label for="language" class="form-label d-block text-start" isRequired="true">{{ localize('Language') }}</x-form.label>
            <x-form.select name="language" class="form-select form-select-transparent form-select--sm" id="language">
                @foreach (languages() as $item)
                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                @endforeach
            </x-form.select>
        </div>

        <div class="col-md-6">
            <x-form.label for="Tone" class="form-label d-block text-start" isRequired="true">{{ localize('Tone') }}</x-form.label>
            <x-form.select name="Tone" class="form-select form-select-transparent form-select--sm" id="tone">
                @foreach (appStatic()::OPEN_AI_TONES as $key => $name)
                    @if($key == 'Professional')
                        <option value="{{ $key }}" selected>{{ $name }}</option>
                    @else
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endif
                @endforeach
            </x-form.select>
        </div>

        @if((isCustomerUserGroup() && allowPlanFeature("allow_seo_keyword")) || (isAdmin() || isAdminTeam()))
            <div class="col-md-6 keywordSeoCheckbox">
                <x-form.label for="checkSeoForKeyword" class="form-label d-block text-start d-flex align-items-center gap-2 cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Per SEO Keyword Analysis cost will be {{getSetting('bulk_keyword_research_per_request_credit_cost', 4)}} credits">
                    <x-form.input type="checkbox" id="checkSeoForKeyword" name="checkSeoForKeyword" value="1" :showDiv="false" />
                    {{ localize('Check SEO Analysis for keywords') }}
                </x-form.label>
                
            </div>
        @endif
    </div>
</div>