@if(openAiErrorMessage() != null)
<div class="col-lg-12">
    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
        {{ openAiErrorMessage() }} @if (!isCustomerUserGroup())<a href="{{ route('admin.settings.credentials')}}">{{ localize('AI Credentials Setup') }}</a>@endif 
    </div>
</div>
@endif