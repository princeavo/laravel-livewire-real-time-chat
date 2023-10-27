<div>
    @if($componentsData)
        @foreach ($componentsData as $data)
        @if ($data['sentFromMe'])
            @livewire('group-message-sent-component',key($data['id']),['data' => $data])
        @else
            @livewire('group-message-receved-component',key($message->id),['data' => $data])
        @endif
        @endforeach
    @endif
</div>
