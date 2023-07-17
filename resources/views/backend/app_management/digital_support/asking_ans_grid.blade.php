<div class="row">
    <h4 class="col-md-12">
        @lang('All Asking & Solution List')
    </h4>
</div>

<div class="row">
    <div class="col-md-4">

        <div class="form-group">
            <label>@lang('What You Need To Search Please Type')</label>
            <div class="input-group date">
                <input type="text" id="search_text" class="form-control"
                       name="search_text" value="{{$searching_text}}" placeholder="@lang('What You Need To Search Please Type')"/>
            </div>
        </div>
    </div>
    <div class="col-md-2" style="
    bottom: -30px;
">
        <button class="btn btn-success" onclick="searchByDText()">@lang('Search')</button>
    </div>
    <div class="col-md-6">

    </div>
</div>
<div id="accordion">
    @php
            $i = 1;
        @endphp

        @foreach ($items as $list)
    <div class="card">
      <div class="card-header bg-success" id="heading{{$i}}">
        <h5 class="mb-0">
          <button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapse{{$i}}" 
            aria-expanded="false" 
          aria-controls="collapse{{$i}}">@lang('Problem/Asking'): {{ $list->question }}
          <span class="text-dark">(@lang('Clicking on this will show answer below'))</span>
          
          </button>
        </h5>
      </div>
  
      <div id="collapse{{$i}}" class="collapse show" aria-labelledby="heading{{$i}}" data-parent="#accordion">
        <div class="card-body">
            {{ $list->answer }}
        </div>
      </div>
    </div>
    @endforeach
    {{$items->links()}}
  </div>
<script>

    function searchByDText() {
        var search_text = $('#search_text').val();
        window.location.href = "{{ url('app-management/all-asking-answer/search?searching_text=') }}" + search_text;
    }
</script>
