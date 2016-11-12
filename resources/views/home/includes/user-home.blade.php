
<div class="home">
    <div class="home-buttons">
        <button type="button" class="pr-button pr-button--home">
            <a href="/recipe/create">+ <i class="fa fa-cutlery"></i> Add a Recipe</a>
        </button>
        <button type="button" class="pr-button pr-button--home">
            <a href="/grocerylist/create">+ <i class="fa fa-shopping-cart"></i> Create a List</a>
        </button>
    </div>

    <div class="divider"></div>

</div>

<div class="home-lists">
    @foreach($lists as $list)
        <h3><i class="fa fa-list"></i> <a href="grocerylist/{{$list->getKey()}}">{{$list->title}}</a></h3>
    @endforeach

    <a href="/grocerylist" class="pr-button pr-button--home-lists">All Lists</a>
</div>

