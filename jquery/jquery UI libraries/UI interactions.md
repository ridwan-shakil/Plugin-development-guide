Main Documentation : https://jqueryui.com/sortable/

## jQuery UI Datepicker
```
$(".date-field").datepicker({

    altField: null,                // Another input to display formatted date
    altFormat: "yy-mm-dd",         // Format for altField
    appendText: "",                // Text next to the field
    autoSize: false,               // Auto-size input to fit date format
    buttonImage: "",               // Image for trigger button
    buttonImageOnly: false,        // Image button only
    buttonText: "Select date",     // Text for trigger button
    changeMonth: false,            // Show month dropdown
    changeYear: false,             // Show year dropdown
    dateFormat: "mm/dd/yy",        // Format of the date displayed
    dayNames: [],                  // Days full names
    dayNamesMin: [],               // Sun → Su
    dayNamesShort: [],             // Sun → Sun
    defaultDate: null,             // Preselected date
    duration: "fast",              // Fade/slide duration
    firstDay: 0,                   // 0 = Sunday, 1 = Monday
    maxDate: null,                 // Maximum selectable date
    minDate: null,                 // Minimum selectable date
    monthNames: [],                // Full month names
    monthNamesShort: [],           // Short month names
    nextText: "Next",              // Next button text
    prevText: "Prev",              // Prev button text
    numberOfMonths: 1,             // Show multiple months
    showButtonPanel: false,        // Today / Done panel
    showCurrentAtPos: 0,           // Current month position
    showOtherMonths: false,        // Show days from other months
    showWeek: false,               // Show week number
    yearRange: "c-10:c+10",        // Year dropdown range
    maxDate: null,                 // Maximum allowed date

    // 🔥 Events
    beforeShow: function(input, inst) {},       // Before datepicker appears
    onChangeMonthYear: function(y, m, inst) {}, // Month or year changed
    onClose: function(dateText, inst) {},       // On close
    onSelect: function(dateText, inst) {},      // When date is selected

});
```


## jQuery UI Sortable

```
$("#element").sortable({

    axis: false,                  // Constrain movement to "x" or "y" axis only
    containment: false,           // Limit dragging inside a parent/container
    cursor: "auto",               // Cursor while sorting (move, pointer, etc.)
    delay: 0,                     // Delay before sorting starts (ms)
    disabled: false,              // Disable sorting
    distance: 1,                  // Min mouse move (px) before sorting starts
    dropOnEmpty: true,            // Allow dropping items into empty lists
    handle: false,                // Drag only when using a specific element
    helper: "original",           // "original" or "clone"
    items: "> *",                 // Items that can be sorted
    opacity: false,               // Set opacity during drag (e.g., 0.6)
    placeholder: false,           // CSS class for placeholder element
    revert: false,                // Smooth animation back to final position
    scroll: true,                 // Auto-scroll during sorting
    tolerance: "intersect",       // "intersect" or "pointer"
    zIndex: 1000,                 // z-index of drag helper

    // 🔥 Events
    start: function(e, ui) {},    // Sorting starts
    sort: function(e, ui) {},     // While moving
    change: function(e, ui) {},   // Placeholder position changed
    update: function(e, ui) {},   // Item position updated (save order)
    stop: function(e, ui) {},     // Sorting finished

});
```

## jQuery UI Draggable
```
$("#element").draggable({

    axis: false,                  // Constrain movement to "x" or "y"
    containment: false,           // Limit dragging within parent/selector/window
    cursor: "auto",               // Cursor while dragging
    cursorAt: false,              // Adjust cursor position relative to item
    delay: 0,                     // Delay before drag starts
    disabled: false,              // Disable dragging
    distance: 1,                  // Min movement before drag starts
    grid: false,                  // Snap movement to a grid (e.g. [20, 20])
    handle: false,                // Restrict dragging handle
    helper: "original",           // "original" or "clone"
    iframeFix: false,             // Prevent issues when dragging over iframes
    opacity: false,               // Opacity while dragging
    revert: false,                // Snap back to start when released
    revertDuration: 500,          // Time for revert animation
    scroll: true,                 // Auto-scroll when near edges
    scrollSensitivity: 20,        // Sensitivity for auto-scroll
    scrollSpeed: 20,              // Scroll speed during drag
    snap: false,                  // Snap to elements
    snapMode: "both",             // "inner", "outer", "both"
    snapTolerance: 20,            // Distance for snap activation
    zIndex: false,                // z-index of helper element

    // 🔥 Events
    start: function(e, ui) {},    // Drag starts
    drag: function(e, ui) {},     // While dragging
    stop: function(e, ui) {},     // Drag stops

});
```

## jQuery UI Resizable
```
$("#element").resizable({

    animate: false,               // Animate resizing
    animateDuration: "slow",      // Animation speed
    animateEasing: "swing",       // Resize animation easing
    aspectRatio: false,           // Lock width/height ratio
    autoHide: false,              // Hide resize handles until hovered
    containment: false,           // Restrict resizing to container
    delay: 0,                     // Delay before resize starts
    disabled: false,              // Disable resizable
    distance: 1,                  // Min movement before resize starts
    ghost: false,                 // Display a semi-transparent resize ghost
    handles: "e, s, se",          // Handles: n, e, s, w, ne, nw, se, sw, all
    helper: false,                // Show helper while resizing
    maxHeight: null,              // Max height
    maxWidth: null,               // Max width
    minHeight: 10,                // Min height
    minWidth: 10,                 // Min width

    // 🔥 Events
    start: function(e, ui) {},    // Resize starts
    resize: function(e, ui) {},   // During resizing
    stop: function(e, ui) {},     // Resize stops

});
```

## jQuery UI Selectable
```
$("#element").selectable({

    autoRefresh: true,            // Recalculate positions on selection
    cancel: "input, textarea",    // Elements that should NOT be selectable
    delay: 0,                     // Delay before selection starts
    disabled: false,              // Disable selectable
    distance: 0,                  // Min mouse move before selection starts
    filter: "*",                  // Items that can be selected
    tolerance: "touch",           // "fit" or "touch"

    // 🔥 Events
    start: function(e, ui) {},     // Selection start
    selecting: function(e, ui) {}, // While selecting
    selected: function(e, ui) {},  // On item selected
    unselecting: function(e, ui) {}, // On unselecting
    unselected: function(e, ui) {},  // Item unselected
    stop: function(e, ui) {},      // Selection finished

});
```
