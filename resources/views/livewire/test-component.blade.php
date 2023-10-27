<div class="conversationReceived">
    @php
        $reads  = [];
        $unReads  = [];
        for($i = 0;$i<count($componentsData);$i++){
            if($i<=count($componentsData)-1-$numberUnreadMessages )
                $reads[] = $componentsData[$i];
            else
                $unReads[] = $componentsData[$i];
        }
    @endphp
    @foreach ($reads as $data)
        @if ($data['sentFromMe'])
            <livewire:message-sent-component :data='$data' :key='$data["id"]' />
            @else
            <livewire:message-receved-component :data='$data' :key='$data["id"]'>
        @endif
    @endforeach
    @if($numberUnreadMessages != 0)
    <div class="d-flex" style="padding-right: 25px;position:relative;top:-30px;margin-top:15px;margin-bottom:-5px">
        <hr style="flex: 1"><i style="position: relative;top:3px">{{ $numberUnreadMessages }} unread @if($numberUnreadMessages !=1) messages @else message @endif</i><hr style="flex: 1">
    </div>
    @endif
    @foreach ($unReads as $data)
        @if ($data['sentFromMe'])
            <livewire:message-sent-component :data='$data' :key='$data["id"]' />
            @else
            <livewire:message-receved-component :data='$data' :key='$data["id"]'>
        @endif
    @endforeach
</div>
