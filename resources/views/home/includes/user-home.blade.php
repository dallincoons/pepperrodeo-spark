<div class="content">
    <div class="section">
            <a href="/recipe/create" class="home-option">+ <i class="fa fa-cutlery fa-fw"> </i>  Add a Recipe</a>
    </div>

    <div class="section">
            <a href="/grocerylist/create" class="home-option">+ <i class="fa fa-shopping-cart fa-fw"> </i>  Create a List</a>
    </div>

    <div class="divider"></div>

    <div class="section">
        <h2>Recent Lists</h2>
        @foreach($lists as $list)
            <h3><i class="fa fa-list"></i> <a href="grocerylist/{{$list->getKey()}}">{{$list->title}}</a></h3>
        @endforeach

        <a href="/grocerylist" class="more">All Lists</a>
    </div>
</div>


