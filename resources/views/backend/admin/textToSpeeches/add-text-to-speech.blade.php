<div class="content-generator__sidebar content-generator__sidebar--end order-1 oreder-md-2">
    <div class="content-generator__sidebar-header p-4">
        <h5 class="mb-0">
            {{ localize('Generate text To Speech') }}
        </h5>
    </div>
    <div class="border-bottom border-top">
        <ul class="nav nav-line-tab px-3 fw-medium" id="ttsTypes">
            
                <li class="nav-item ttsLi" data-engine="{{ appStatic()::ENGINE_OPEN_AI }}">
                    <a href="#{{ appStatic()::ENGINE_OPEN_AI }}" class="nav-link active ful" data-bs-toggle="tab"
                        aria-selected="true" >
                        {{localize('OpenAI')}}
                    </a>
                </li>
            @if(getSetting('eleven_labs') != '0')

            <li class="nav-item ttsLi" data-engine="{{ appStatic()::ENGINE_ELEVEN_LAB }}">
                <a href="#{{ appStatic()::ENGINE_ELEVEN_LAB }}" class="nav-link" data-bs-toggle="tab"
                    aria-selected="false" >
                    {{localize('ElevenLabs')}}
                </a>
            </li>
            @endif
            @if(getSetting('enable_azure') != '0')

            <li class="nav-item ttsLi" data-engine="{{ appStatic()::ENGINE_AZURE }}">
                <a href="#{{ appStatic()::ENGINE_AZURE }}" class="nav-link " data-bs-toggle="tab"
                    aria-selected="false" >
                   {{localize('Azure')}}
                </a>
            </li>
            @endif

            @if(getSetting('enable_google_tts') != '0')

            <li class="nav-item ttsLi" data-engine="{{ appStatic()::ENGINE_GOOGLE_TTS }}">
                <a href="#{{ appStatic()::ENGINE_GOOGLE_TTS }}" class="nav-link" data-bs-toggle="tab"
                    aria-selected="false" >
                    {{localize('Google')}}
                </a>
            </li>
            @endif
        </ul>
    </div>
    <div class="content-generator__sidebar-body p-3">
        <div class="tab-content">
           @include('backend.admin.textToSpeeches.inc.open-ai-text-to-speech')
           @include('backend.admin.textToSpeeches.inc.eleven-labs-text-to-speech')            
           @include('backend.admin.textToSpeeches.inc.azure-text-to-speech')            
           @include('backend.admin.textToSpeeches.inc.google-text-to-speech')            
        </div>
    </div>
   
</div>