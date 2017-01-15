Vue.component('all-recipes-list', {

    props : ['recipes', 'groupedRecipes'],

    methods : {
        submitSave(){
            Bus.$emit('saveSubmitted');
        }
    },

    data() {
        return {
            selectedItems : []
        }
    },

    template : `
        <div class="category-wrapper">
            
            <div v-if="recipes.length">
                <ul v-for="(recipes, category) in groupedRecipes">
                    <li class="category-title"><h3>{{category}}</h3></li>
                    <li>
                        <ul class="recipes">
                                <li v-for="recipe in recipes" class="recipe">
                                    <label class="control control--checkbox"><a>{{recipe.title}}</a>
                                        <input type="checkbox" v-model="selectedItems" id="cbox1" name="recipeIds[]"  :value="recipe.id">
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="lists-wrapper no-content" v-else>
                <h4>Looks like you don't have any recipes yet!</h4>
                <a href="/recipe/create" class="pr-button save-button"><i class="fa fa-plus-circle"></i> Add a Recipe</a>
            </div>
            
            <div class="centering-buttons">
                <input v-show="selectedItems.length" v-on:click="submitSave()" type="button" value="Delete" class="pr-btn save-button recipe-list-delete-btn">
            </div>
            
        </div>
            `
});