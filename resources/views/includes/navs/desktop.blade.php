<nav class="l-nav">
    <ul>
        <li class="l-brand"><a href="/"><h1>Pepper Rodeo</h1></a></li>
        <li class="l-brand l-subtitle">Your recipes & grocery lists in one place.</li>

        <li  class="l-nav-li"><a href="/recipe" class="{{ set_active_strict('recipe') }}"><i class="fa fa-cutlery"></i> My Recipes</a>
            <div class="l-dropdown-content">
                <a href="/recipe/create" class="{{ set_active_strict('recipe/create') }}"><i class="fa fa-plus"></i> Add a Recipe</a>
            </div>

        </li>

        <li class="l-nav-li"><a href="/grocerylist" class="{{ set_active_strict('grocerylist') }}"><i class="fa fa-shopping-cart"></i> My Lists</a>
            <div class="l-dropdown-content">
                <a href="/grocerylist/create" class="{{ set_active_strict('grocerylist/create') }}"><i class="fa fa-plus"></i> Create New List</a>
            </div>
        </li>
        <li class="l-nav-li"><a href="/settings"><i class="fa fa-user"></i> My Settings</a>
            <div class="l-dropdown-content">
                <a href="/logout"><i class="fa fa-chevron-circle-right"></i> Logout</a>
            </div>
        </li>
    </ul>
</nav>
