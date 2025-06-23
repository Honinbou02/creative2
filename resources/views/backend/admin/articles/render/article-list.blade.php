@forelse($lists ?? [] as $key => $row)
    <tr>
        <td class="text-center">{{ $key + 1 + ($lists->currentPage() - 1) * $lists->perPage() }}</td>
        <td class="fs-sm">{!! Str::limit($row->topic, 40, '...') !!}</td>
        <td class="fs-sm" title="{{ $row->selected_title }}">
            @if ($row->wp_post_id )
                [{{ $row->wp_post_id }}] 
            @endif
            {!! Str::limit($row->selected_title, 60, '...') !!}
        </td>
        <td>
            <span class="fs-sm">{{ $row->generatedArticles->count() == 0 ? 1 : $row->generatedArticles->count() }}
                {{ localize('Times') }}
            </span>
        </td>
        <td class="fs-sm">{{ $row->total_words }}</td>
        <td class="fs-sm text-muted">{{ manageDateTime($row->created_at, 7) }}</td>
        <td class="text-center">
            <span class="badge {{ $row->completed_step == 5 ? 'bg-soft-success' : 'bg-soft-primary' }} rounded-pill text-capitalize">
                {{ $row->completed_step == 5 ? localize('Completed') : localize('Incomplete') }}
            </span>
        </td>
        @if (isModuleActive('WordpressBlog') && wpCredential())
            
        @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (!isCustomerUserGroup()))
            <td class="text-center">
                <span class="badge {{ $row->is_published_wordpress == 1 ? 'bg-soft-success' : 'bg-soft-warning' }} rounded-pill text-capitalize">
                    {{ $row->is_published_wordpress ? localize('Pushed') : localize('Not Pushed') }}
                </span>
            </td>
            <td class="fs-sm text-center text-muted">{{ $row->wp_synced_at ? manageDateTime($row->wp_synced_at, 7) : '--' }}</td>
            @endif
        @endif

        <td class="text-center" style="width: 100px;">
            @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || ((isAdmin() || isAdminTeam()) && isRouteExists('admin.wordpress.articles.edit')))
                <a href="{{ route('admin.wordpress.articles.edit', $row->id) }}" class="editIcon me-1">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Edit Article') }}"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif

            @if ($row->article_source == 2 && ((isCustomerUserGroup() && (allowPlanFeature("allow_seo_content_optimization"))) || (isRouteExists('admin.seo.storeWpPostSeoChecker'))))
                <a href="{{ route('admin.seo.storeWpPostSeoChecker', $row->id) }}" class="editIcon me-1 wpPostSeoCheckerBtn" data-bs-toggle="offcanvas" data-bs-target="#offCanvasArticleSeoChecker">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('SEO Checker') }}"><i data-feather="activity" class="icon-14"></i></span>
                </a>
            @elseif ($row->article_source == 1 &&  ((isCustomerUserGroup() && (allowPlanFeature("allow_seo_content_optimization"))) || (isRouteExists('admin.seo.storeWpPostSeoChecker'))))
                <a href="{{ route('admin.seo.storeArticleSeoChecker', $row->id) }}" class="editIcon me-1 articleSeoCheckerBtn" data-bs-toggle="offcanvas" data-bs-target="#offCanvasArticleSeoChecker">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('SEO Checker') }}"><i data-feather="activity" class="icon-14"></i></span>
                </a>
            @endif

            @if (isModuleActive('WordpressBlog') && wpCredential())
                @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (isAdmin() || isAdminTeam()))
                    <a href="#" class="overly-btn overly-delete bg-white text-light me-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPublishedToWordpress" onclick="publishedBlogPost({{$row->id}}, {{ $row->wp_post_id }})">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{localize('Push to WordPress')}}"><i data-feather="arrow-up-circle" class="icon-14 text-black"></i></span>
                    </a>
                @endif
            @endif

            @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (isRouteExists('admin.articles.destroy')))
                <a href="#" data-id="{{ $row->id }}" data-href="{{ route('admin.articles.destroy', $row->id) }}" data-method="DELETE" class="erase btn-sm p-0 bg-transparent border-0" type="button">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Delete Article') }}" class="text-danger ms-1"><i data-feather="trash-2" class="icon-14"></i></span>
                </a>
            @endif 
        </td>
    </tr>
@empty
    <x-common.empty-row colspan=@if (isModuleActive('WordpressBlog') && wpCredential()) 10 @else 8 @endif />
@endforelse

{{ paginationFooter($lists, isModuleActive('WordpressBlog') && wpCredential() ? 10 : 8) }}
