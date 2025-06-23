@if(isAdmin())
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-2 flex-shrink-0">
                        <div class="text-center rounded-circle shadow-sm bg-light">
                            <span><i data-feather="users" class="icon-16"></i></span>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">{{ $total_customers }}</h6>
                        <span class="fs-sm">{{ localize('Total Customer') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif