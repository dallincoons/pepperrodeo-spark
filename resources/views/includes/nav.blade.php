<nav class="pr-nav-lg">
    <ul>
        <li class="{{ set_active('/') }}"><a href="/"><h1>Pepper Rodeo</h1></a></li>
        <li class="{{ set_active('recipe') }}"><a href="/recipe"><i class="fa fa-cutlery"></i> Recipes</a></li>
        <li class="{{ set_active('grocerylist') }}"><a href="/grocerylist"><i class="fa fa-shopping-cart"></i> Lists</a></li>
        <li><a><i class="fa fa-user"></i> Account</a></li>
    </ul>
</nav>


{{--Mobile Header--}}
<nav class="brand">
    <div>
        <h3>PepperRodeo</h3>
    </div>
</nav>



{{--Mobile "footer" navigation--}}

<nav class="pr-nav">
    <ul>
        <li class="{{ set_active('recipe') }}"><a href="/recipe"><i class="fa fa-cutlery"></i></a></li>
        <li class="{{ set_active('grocerylist') }}"><a href="/grocerylist"><i class="fa fa-shopping-cart"></i></a></li>
        <li class="{{ set_active('/') }}"><a href="/"><i class="fa fa-home"></i></a></li>
        <li><a><i class="fa fa-user"></i></a></li>
    </ul>
</nav>



