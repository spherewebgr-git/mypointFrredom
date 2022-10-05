/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 5.0
	Author: PIXINVENT
	Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */

$c = jQuery.noConflict();

$c(document).ready(function(){
    if($c(".datepicker-date-display .date-text").length > 0) {
        // GREEK DATES
        $c(".datepicker-date-display .date-text").each(function(){
            let _original = $c(this).text().toLowerCase().replace(/\b(\w)/g, s => s.toUpperCase());
            var _responce = _original
                .replace("Mon", "Δευτέρα")
                .replace("Tue", "Τρίτη")
                .replace("Wed", "Τετάρτη")
                .replace("Thu", "Πέμπτη")
                .replace("Fri", "Παρασκευή")
                .replace("Sat", "Σάββατο")
                .replace("Sun", "Κυριακή")
                .replace("Jan", "Ιανουαρίου")
                .replace("Feb", "Φεβρουαρίου")
                .replace("Mar", "Μαρτίου")
                .replace("Apr", "Απριλίου")
                .replace("May", "Μαϊου")
                .replace("Jun", "Ιουνίου")
                .replace("Jul", "Ιουλίου")
                .replace("Aug", "Αυγούστου")
                .replace("Sep", "Σεπτεμβρίου")
                .replace("Oct", "Οκτωβρίου")
                .replace("Nov", "Νοεμβρίου")
                .replace("Dec", "Δεκεμβρίου");
            $p(this).text(_responce);
        });
    }

});
