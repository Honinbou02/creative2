<div class="card">
    <form action="{{ route('admin.settings.store') }}" method="POST" class="invoice-settings-form settingsForm"
    enctype="multipart/form-data" id="invoice-settings-form">
    <div class="card-header">
        <h5 class="mb-0">{{ localize('Invoice Settings') }}</h5>
    </div>
    <div class="card-body">
        <div class="tab-content">
            
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">                       
                        <x-form.label for="order_code_prefix" label="{{ localize('Code Prefix') }}" isRequired=true />
                        <x-form.input name="settings[order_code_prefix]" id="order_code_prefix"
                                      type="text"
                                      placeholder=""
                                      value="{{ getSetting('order_code_prefix') }}"
                                      showDiv=false
                        />
                    </div>
                    <div class="col-md-12">                       
                        <x-form.label for="order_code_start" label="{{ localize('Code Prefix Start') }}" isRequired=true />
                        <x-form.input name="settings[order_code_start]" id="order_code_start"
                                      type="text"                                   
                                      value="{{ getSetting('order_code_start') }}"
                                      showDiv=false
                        />
                    </div>
                    <div class="col-md-12">                       
                        <x-form.label for="invoice_thanksgiving" label="{{ localize('Thanks Message') }}" isRequired=true />
                        <x-form.textarea name="settings[invoice_thanksgiving]" id="invoice_thanksgiving"
                                      type="text"
                                      value="{{ getSetting('invoice_thanksgiving') }}"
                                      showDiv=false
                        />
                    </div>
                </div>
          
        </div>
    </div>
    <div class="card-footer bg-transparent mt-3">
        <x-form.button type="submit" class="settingsSubmitButton btn-sm"><i data-feather="save"></i>{{ localize('Save Configuration') }}</x-form.button>
    </div>
</form>
</div>
