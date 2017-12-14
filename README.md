<!--h-->
# Vue Admin LTE

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/22a9c82803ce410caee8ddc67957d027)](https://www.codacy.com/app/laravel-enso/VueAdminLTE?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/VueAdminLTE&amp;utm_campaign=Badge_Grade)
[![StyleCI](https://styleci.io/repos/99346727/shield?branch=master)](https://styleci.io/repos/99346727)
[![License](https://poser.pugx.org/laravel-enso/vueadminlte/license)](https://https://packagist.org/packages/laravel-enso/vueadminlte)
[![Total Downloads](https://poser.pugx.org/laravel-enso/vueadminlte/downloads)](https://packagist.org/packages/laravel-enso/vueadminlte)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/vueadminlte/version)](https://packagist.org/packages/laravel-enso/vueadminlte)
<!--/h-->

Admin LTE Vueified for [Laravel Enso](https://github.com/laravel-enso/Enso)

### Features
- `Addresses` - polymorphic addresses functionality
- `Box`
- `BoxWidget`
- `Breadcrumbs` - uses is included in the `Page` component and automatically generates the breadcrumbs
- `InfoBox`
- `Notifications` - is the notifications menu, used in the header 
- `Overlay` - is a spinner overlay used to indicate the loading state
- `Page` - is the container for the page contents
- `RoAddresses` - an extension for addresses with Romanian-specific formatting
- `SmallBox`
- `Tabs`
- `UserMenu` - is the user menu, used in the header
- `UserWidget`
- `VueFilter` - additional filters for DataTable 

#### Addresses
Takes the following parameters:
 `type` - string, the addressable model alias you set in the config | required
- `id` - number, the id of the addressable model | required
- `theme` - string, the class used for setting the styling of the box. Defaults to `primary`.
- `solid` - boolean, a flag for showing a solid type of a box. Defaults to `false`.
- `open` - boolean, a flag for the starting style (open/closed) of the box. Defaults to `true`.
- `title` - string, the text for the box title. Defaults to null.


#### Box
Takes the following parameters:
- `theme` - string, the class used for setting the styling of the box.
- `border`, boolean, a flag for showing a border arount the component. Defaults to `false`.
- `solid` - boolean, a flag for showing a solid type of a box. Defaults to `false`.
- `open` - boolean, a flag for the starting style (open/closed) of the box. Defaults to `true`.
- `footer` - string, a flag for displaying the footer. Defaults to `false`.
- `icon` - string, the class for the icon of the box. Defaults to null.
- `title` - string, the text for the box title. Defaults to null.
- `search` - boolean, a flag for displaying the search input. Defaults to `false`.
- `badge` - number, the number to be displayed in a badge, in the box header. Defaults to null.
- `refresh` - boolean, a flag for showing the refresh control. Defaults to false. 
- `collapsible` - boolean, a flag for showing the minimization control. Defaults to false.
- `removable` - boolean, a flag for showing the close control. Defaults to false.
- `overlay` - boolean, a flag for displaying the loading overlay (spinner). Defaults to false. 
- `bodyStyle` - object, an object for styling the body. Defaults to `{}`.

#### Breadcrumbs
- takes no parameters.
- uses the global `Store` object and the given breadcrumbs to automatically generate breadcrumbs for the current page.
- is included in the `Page` component but can be used standalone if needed, as long as it has access to the `Store`.

### HowToVideos
Takes the following parameters:
- `video`, object, contains the information to display a video | required
- `tagList`, object, contains the list of all available tags | required

Note that this component has not been designed to be reused outside of the HowToVideos menu/page.

#### Info Box
Takes the following parameters:
- `theme` - string, the class used for setting the styling of the box. Required.
- `icon` - string, the class for the icon of the box. Defaults to null.
- `text` - string, the text shown in the box. Defaults to null.
- `number`, string, the text shown in the box. Defaults to null.
- `progress` - string, progress percentage. Defaults to `false`.
- `description` - string, the description shown for the progress. Defaults to `false`.

#### Notifications
Takes the following parameters:
- `user-id` - number, the id of the user for whom the notifications are loaded. Required.
- `paginate` - number, the # of items on one page, shown or loaded. Defaults to 6.

#### Overlay
Takes the following parameters:
- `line-fg-Color` - string, the color for the foreground of the spinner. Defaults to `#41b883`.
- `line-bg-Color` - string, the color for the background of the spinner. Defaults to `transparent`.
- `speed` - number, the speed of the spinner. Defaults to 1.
- `size` - string, the size of the spinner. Defaults to `medium`.

#### Page
Takes the following parameters:
- `custom-render` - function, the method for handling custom rendering. Defaults to null.

#### Romanian Addresses
Takes the same parameters as Addresses - see above.

#### Small Box
Takes the following parameters:
- `theme` - string, the class used for setting the styling of the box.
- `icon` - string, the class for the icon of the box. Defaults to null.
- `title` - string, the text for the box title. Defaults to null.
- `body`, string, text shown as body. Defaults to null.
- `overlay` - boolean, a flag for displaying the loading overlay (spinner). Defaults to false. 

#### Tabs
Takes the following parameters:
- `tabs` - array, array of strings / objects used for rendering the tabs and their slots. Required.
- `title` - string, the text for the box title. Defaults to null.
- `reverse` - boolean, flag for reversing the tab list. Defaults to false.
- `active`, number, the index of the active tab. Defaults to 0.
- `icon` - string, the class for the icon of the box. Defaults to null. 

#### User Menu
Takes no parameters, uses the global `Store` variable

#### User Widget
- `theme` - string, the class used for setting the styling. Required.
- `background` - string, the class used for setting the background.
- `avatar` - string, the url for the location of the avatar picture.
- `name` - string, the name of the user displayed. Defaults to null.
- `position` - string, the position of the user. Defaults to null.
- `items` - array, list of items to be displayed. Each item must be an object with `value` and `label` properties. Defaults to empty array.
- `overlay` - boolean, a flag for displaying the loading overlay (spinner). Defaults to false.

### Vue Filter
Takes the following parameters:
- `title` - string, the text for the box title. Defaults to null.
- `theme` - string, the class used for setting the styling of the box. Defaults to `primary`.
- `options` - array, the list of options to display. Defaults to empty array
- `value` - anything, the default, starting value | required
- `offSwitch` - boolean, flag that determines if an off switch is rendered. Defaults to `true`

To use it include it in the page:
```
<vue-filter
        title="Taxes Paid"
        v-model="filters.orders.paid_taxes"
        :options="vueFilterOptions">
</vue-filter>
```

where the `vueFilterOptions` and `filters` may be something like:

```
vueFilterOptions: [
    {value:true, label:"Yes"},
    {value:false, label:"No"}
],
filters: {
    orders: {                
        paid_taxes: '',                
    }
},
```

Next, when defining your DataTable, make sure you give it your filters:

```
<data-table 
    source="orders" 
    :extra-filters="filters" 
    id="index-orders-id">
</data-table>
```

Note that you may use more than one such filter, just bind it inside the same encompassing `filters` object 
and it will get passed to the datatables BE logic.  

<!--h-->
### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.
<!--/h-->