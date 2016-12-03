<div class="recipe-section">
    <label for="title" class="form-heading">Title*</label>
    {!! Form::text('title', null,
        ['id' => 'title',
         'placeholder' => 'Chicken & Rice Casserole',
         'required',
         'data-parsley-errors-messages-disabled',
         'data-parsley-trigger' => 'submit'])
     !!}
</div>

<div class="recipe-section">
    <label for="category" class="form-heading">Category*</label>
    <div class="recipe-section__selection-group--category">
        <select v-model="selectedCategory" class="recipe-section__selection--category" name="category" style="flex:1;" required data-parsley-errors-messages-disabled data-parsley-trigger="submit">
            <option v-for="category in categories" :value="[category.id, category.name]">@{{category.name}}</option>
        </select>
        <button type="button" v-show="!addingCategory" v-on:click="addingCategory = true" class="recipe-section__button"><i class="fa fa-plus-circle"></i> Add New</button>
    </div>
    <div v-show="addingCategory" class="addingCategory">
        <input v-model="newCategory" placeholder="Favorites" />
        <button v-on:click="addNewCategory()" type="button" class="recipe-section__button"><i class="fa fa-plus-circle"></i> Add</button>
        <button v-on:click="addingCategory = false" type="button" class="recipe-section__button">Cancel</button>
    </div>
</div>

<label class="form-heading">Ingredients*</label>

<div class="ingredient-section">

    <div v-for="(item, index) in recipeItems" class="ingredient-inputs">
        <input type="hidden" :name="'recipeFields[' + index + '][id]'" :value="item.id"/>
        <div class="ingredient-input">
            <label for="quantity" class="sub-heading">Qty</label>
            <input type="text" id="quantity" v-model="item.quantity" :name="'recipeFields[' + index + '][quantity]'" class="ingredient-info" placeholder="3" :value="item.quantity" required data-parsley-errors-messages-disabled data-parsley-trigger="submit"/>
        </div>

        <div class="ingredient-input">
            <label for="type" class="sub-heading">Type</label>
            <input type="text" id="type" v-model="item.type" :name="'recipeFields[' + index + '][type]'" class="ingredient-info" placeholder="cups"  :value="item.type" required data-parsley-errors-messages-disabled data-parsley-trigger="submit"/>
        </div>

        <div class="ingredient-input">
            <label for="ingredient" class="sub-heading">Ingredient</label>
            <input type="text" id="ingredient" v-model="item.name" :name="'recipeFields[' + index + '][name]'" class="ingredient-info" placeholder="flour" :value="item.name" required data-parsley-errors-messages-disabled data-parsley-trigger="submit"/>
        </div>

        <div class="ingredient-input">
            <label for="type" class="sub-heading">Department</label>
            <select v-model="item.item_category_id" :name="'recipeFields[' + index + '][item_category_id]'" class="recipe-section__selection--category dept_select ingredient-info" :value="item.item_category_id" required data-parsley-errors-messages-disabled data-parsley-trigger="submit">
                @foreach($itemCategories as $category)
                    <option value="{{ $category->id }}"  class="dropdown-item">{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        <div v-on:click="removeItem(index)">X</div>
    </div>

    <div class="ingredient-input">
        <label for="quantity" class="sub-heading">Qty</label>
        <input type="text" id="quantity" v-model="item.quantity" class="ingredient-info" placeholder="3" :value="item.quantity" />
    </div>

    <div class="ingredient-input">
        <label for="type" class="sub-heading">Type</label>
        <input type="text" id="type" v-model="item.type" class="ingredient-info" placeholder="cups"  :value="item.type"/>
    </div>

    <div class="ingredient-input">
        <label for="ingredient" class="sub-heading">Ingredient</label>
        <input type="text" id="ingredient" v-model="item.name" class="ingredient-info" placeholder="flour" :value="item.name" />
    </div>

    <div class="ingredient-input">
        <label for="type" class="sub-heading">Department</label>
        <select v-model="item.item_category_id" class="recipe-section__selection--category dept_select ingredient-info" :value="item.item_category_id">
            @foreach($itemCategories as $category)
                <option value="{{ $category->id }}"  class="dropdown-item">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="add-ingredient" v-on:click="addNewItem()"><i class="fa fa-plus-circle"></i> Add ingredient</div>
<div class="recipe-section">
    <label for="directions" class="form-heading">Directions*</label>
    {!! Form::textarea('directions', null,
        ['placeholder' => 'Preheat oven to 350°',
         'required',
         'data-parsley-errors-messages-disabled',
         'data-parsley-trigger' => 'submit']) !!}
</div>

@if (count($errors) > 0)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
