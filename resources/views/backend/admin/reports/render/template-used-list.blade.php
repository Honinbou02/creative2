 @forelse ($usage as $key => $use)
     <tr>
         <td class="text-center">
             {{ $key + 1 + ($usage->currentPage() - 1) * $usage->perPage() }}</td>
         <td>
             <h6 class="fs-sm mb-0 ms-2">{{ $use->template_name }}
             </h6>
         </td>

         <td class="text-end">
             {{ $use->template_word_counts() }}
         </td>
     </tr>
    @empty
     <x-common.empty-row colspan=5 />
 @endforelse
 {{ paginationFooter($usage, 5) }}
