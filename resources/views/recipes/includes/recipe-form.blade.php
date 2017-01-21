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
        <button type="button" v-show="!addingCategory" v-on:click="addCategory()" class="recipe-section__button"><i class="fa fa-plus-circle"></i> Add New</button>
    </div>
</div>

<label class="form-heading">Ingredients*</label>

<div class="ingredient-section">

    <div v-for="(item, index) in recipeItems" class="ingredient-inputs">
        <input type="hidden" :name="'recipeFields[' + index + '][id]'" :value="item.id"/>
        <div class="ingredient-input">
            <label for="quantity" class="sub-heading">Qty</label>
            <input type="text" id="quantity" :name="'recipeFields[' + index + '][quantity]'" v-model="item.quantity" class="ingredient-info" placeholder="3" :value="item.quantity" required data-parsley-errors-messages-disabled data-parsley-trigger="submit"/>
        </div>

        <div class="ingredient-input">
            <label for="type" class="sub-heading">Type</label>
            <input type="text" id="type" :name="'recipeFields[' + index + '][type]'" v-model="item.type" class="ingredient-info" placeholder="cups"  :value="item.type" required data-parsley-errors-messages-disabled data-parsley-trigger="submit"/>
        </div>

        <div class="ingredient-input">
            <label for="ingredient" class="sub-heading">Ingredient</label>
            <input type="text" id="ingredient" :name="'recipeFields[' + index + '][name]'" v-model="item.name" class="ingredient-info" placeholder="flour" :value="item.name" required data-parsley-errors-messages-disabled data-parsley-trigger="submit"/>
        </div>

        <div class="ingredient-input">
            <label for="type" class="sub-heading">Department</label>
            <select :name="'recipeFields[' + index + '][department_id]'" v-model="item.department_id" class="recipe-section__selection--category dept_select ingredient-info" :value="item.department_id" required data-parsley-errors-messages-disabled data-parsley-trigger="submit">
                <option v-for="department in departments" :value="department.id"  class="dropdown-item">@{{department.name}}</option>
            </select>
            <input v-model="item.department_name" :name="'recipeFields[' + index + '][department_name]'" type="hidden">
        </div>

        <div v-on:click="removeItem(index)" class="ingredient-input rmv-ingred"><i class="fa fa-times-circle-o"></i></div>
    </div>


    <template v-if="showNewItemInputs">
        <div class="ingredient-input qty-input-wrapper">
            <label for="quantity" class="sub-heading">Qty</label>
            <input type="number" name="price" step="0.01" data-parsley-type="number" id="quantity" :name="'recipeFields[' + -1 + '][quantity]'" v-model="item.quantity" class="ingredient-info qty-input" placeholder="3" :value="item.quantity" required data-parsley-errors-messages-disabled data-parsley-trigger="submit"/>
        </div>

        <div class="ingredient-input">
            <label for="type" class="sub-heading">Type</label>
            <input type="text" id="type" :name="'recipeFields[' + -1 + '][type]'" v-model="item.type" class="ingredient-info" placeholder="cups"  :value="item.type" required data-parsley-errors-messages-disabled data-parsley-trigger="submit"/>
        </div>

        <div class="ingredient-input">
            <label for="ingredient" class="sub-heading">Ingredient</label>
            <input type="text" id="ingredient" :name="'recipeFields[' + -1 + '][name]'" v-model="item.name" class="ingredient-info" placeholder="flour" :value="item.name" required data-parsley-errors-messages-disabled data-parsley-trigger="submit"/>
        </div>

        <div class="ingredient-input">
            <label for="type" class="sub-heading">Department</label>
            <select @change="checkAddNew(item.department_id)" v-model="item.department_id" :name="'recipeFields[' + -1 + '][department_id]'" class="recipe-section__selection--category dept_select ingredient-info" :value="item.department_id">
            <option v-for="department in departments" :value="department.id"  class="dropdown-item">@{{department.name}}</option>
            <option value="0">+ Add New</option>
            </select>
            <input v-model="item.department_name" :name="'recipeFields[' + -1 + '][department_name]'" type="hidden">
        </div>
    </template>
</div>

<div class="add-ingredient" v-on:click="addNewItem()"><i class="fa fa-plus-circle"></i> Add ingredient</div>
<div class="recipe-section">
    <label for="directions" class="form-heading">Directions*</label>
    {!! Form::textarea('directions', old('directions'),
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