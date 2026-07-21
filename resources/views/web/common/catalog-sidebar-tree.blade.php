@php
    $idPrefix = $idPrefix ?? 'cat';
    $openIds = $openIds ?? [];
@endphp
@foreach($nodes as $node)
    @php
        $hasChildren = $node->childrenRecursive && $node->childrenRecursive->count() > 0;
        $isOpen = in_array($node->entity_id, $openIds, true);
        $isActive = $openIds && $openIds[0] === $node->entity_id;
        $margin = 10 * max(0, ($node->level ?? 2) - 2);
        $link = $node->translated_link;
        $id = $node->entity_id;
    @endphp
    <div class="catalog-sidebar-item" style="margin-left: {{ $margin }}px;">
        <div class="catalog-sidebar-row {{ $isActive ? 'active' : '' }}">
            <a href="{{ url($base . $link) }}" class="catalog-sidebar-link-inner">
                <span class="catalog-sidebar-name">{{ $node->translated_name }}</span>
            </a>
            @if($hasChildren)
                <button type="button" class="catalog-sidebar-toggle" data-target="{{ $idPrefix }}-{{ $id }}" aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                    <i class="fa-regular {{ $isOpen ? 'fa-square-minus' : 'fa-square-plus' }}"></i>
                </button>
            @endif
        </div>
        @if($hasChildren)
            <div id="{{ $idPrefix }}-{{ $id }}" class="catalog-sidebar-children {{ $isOpen ? 'open' : '' }}">
                @include('web.common.catalog-sidebar-tree', [
                    'nodes' => $node->childrenRecursive,
                    'base' => $base,
                    'idPrefix' => $idPrefix,
                    'openIds' => $openIds,
                ])
            </div>
        @endif
    </div>
@endforeach
