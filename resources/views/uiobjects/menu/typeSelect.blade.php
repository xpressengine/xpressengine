<ul class="list-group">
    @foreach($types as $id => $menuType)
        <li class="list-group-item">
           <div class="radio" style="padding: 12px 15px;">
               <label>
                   <input type="radio" name="selectType" value="{{ short_module_id($menuType['id']) }}" @if(short_module_id($selectedTypeId) === short_module_id($menuType['id'])) checked @endif>
                   <b>{{ $menuType['title'] }}</b>
                   <small>{{ $menuType['description'] }}</small>
               </label>
           </div>
        </li>
    @endforeach
</ul>