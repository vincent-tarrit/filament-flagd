<div class="space-y-1">
    <ul  class="mt-2 space-y-1 border-l-2 border-gray-300 pl-4">
        @foreach($conditions as $condition)
            <li class="p-2 border rounded bg-gray-50">
                <strong>Type:</strong> {{ $condition->type }}
                @if($condition->ref)
                    | <strong>Ref:</strong> {{ $condition->reference?->key ?? $condition->ref }}
                @endif
                @if($condition->attribute)
                    | <strong>Attribute:</strong> {{ $condition->attribute }}
                @endif
                @if($condition->value)
                    | <strong>Value:</strong> {{ $condition->value }}
                @endif
                @if($condition->values)
                    | <strong>Values:</strong> {{ is_array($condition->values) ? implode(', ', $condition->values) : $condition->values }}
                @endif
                @if($condition->percent)
                    | <strong>{{ $condition->percent }} %</strong>
                @endif
            </li>
        @endforeach
    </ul>
</div>
