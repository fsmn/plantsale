# How to Test Changes After Code Changes

## Home Page Functionality

On the home page in your docker environment or at https://backoffice.t7test.io, test the following:

* Can you create a new common?
* Can you create a new grower?
* Can you export for Quark?
* When you click on Show Order Totals, Show Category Totals, Show Flat Totals do they work? Do they behave like they do
  on the live site?

## Menus

### Main Menu Bar

* Home should always go to the home page.
* Entering at least three characters in the search field should produce a list where a variety, common, or genus
  contains the letters you enter.
* Except for "Grower Totals" the remaining buttons in the main menu should reveal a pop-up dialog with search options.
* Grower Totals should produce a list of growers (more testing on this later).

### Utility Menu

* Every user has a button with their name. This should open a page that provides options (depending on user role) to
  allow users to change their email address, password, and roles.
* Administrators have a button that shows a list of users
* Administrators have a "Menu" button that links to an editor for managing global menu options. These are for generic
  menus of various types used in the UI
* Administrators and "exporters" can use the DB Download button to download individual tables or the entire database.
  This is available for developers to get a full download of the live site, and to allow users to create backups before
  making significant changes.
* Log out should do what it says.

## Data Entry and Aggregation

There are four main focuses of direct data entry:

* Common: more or less representing the genus of plants from any ear of the sale.
* Variety: All the plant varieties offered from any year Orders
* Orders: The orders and inventory records for all varieties.
* Growers: Growers who supply all the orders

### Common
Common is the Plant Sale team's term for the parent groupings of plants, many of which are equivalent to the _genus_.

#### Common Search
The popup dialog for common search should provide the option to enter some or all of the common's name, genus, select a category, sub category, sun requirements, and the option to choose whether the sunlight requirement uses an "and" or "or", wording in the common's description, and the ability to restrict to commons whose varieties have orders from a specific year. 

Make sure that searches for partial strings like "Pan" for Pansy work. 
Make sure that when a category is selected that the subcategory is restricted to a shorter list (this varies by category. Some categories have no subcategories, others have several. No categories will have all the available subcategories)

The resulting list should provide a summary of the search parameters, an option to refine which should produce the same search parameters originally used, and a list of results. 

In the list of results there should be an option to view "Details" of individual commons.

#### Common Details
A Common may not always have varieties associated with it. This is rare, and usually an artifact from the migration of data from the original FileMaker Pro data source. 

The common view page should offer two buttons: Edit and Add a Variety. 
It should also allow in-line editing.

Test to be sure each field can be successfully edited and that the data can be saved. 

Test that the edit popup also works. Be sure that selecting a category limits the subcategories available. 

#### Test adding a variety.
Click on the Add a variety button
Enter values in the various fields. 
Check the box that says "Add a new order for this variety"

After filling out the values, a new dialog should appear with options to add order details. 

Upon completion, you should be redirected to the common view page, where the new variety should be listed. 

### Variety Search and Editing
