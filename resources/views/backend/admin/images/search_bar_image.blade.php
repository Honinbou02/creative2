<form action="" method="get" name="searchForm" id="searchForm">
    <div class="row g-1">
        <div class="col-auto flex-grow-1">
            <div class="tt-search-box w-auto">
                <div class="input-group">
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                            data-feather="search" class="icon-16"></i></span>
                    <input class="form-control rounded-start form-control-sm" type="text" name="f_search" id="f_search" placeholder="Search...">
                </div>
            </div>
        </div>
        <div class="col-auto">
            <x-form.button color="dark" type="button" class="btn-sm" id="searchBtn">
                <i data-feather="search" class="icon-14"></i>
                {{ localize('Search') }}
            </x-form.button>
        </div>
    </div>
</form>
