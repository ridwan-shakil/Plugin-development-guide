# Ajax timing-control methods
1) Debounce = Runs after the user stops typing, Useful for input fields, search boxes, autosave
2) Throttle = allow the function to run at most once every X ms.
3) requestAnimationFrame = not so usefull
   
		Debounce → Typing, filter search, autosave
		Throttle → Dragging, scrolling, window resize, repeated clicks
		requestAnimationFrame → Animations, live previews, block editor updates

## ------- Debounce -------

  ### use "Debounce" method to reduce ajax calls (increase ajax performance) 
  ### Runs after the user stops typing, Useful for input fields, search boxes, autosave
  
			saving data .on("blur", => {} ) is not enough, as it may not fire always,
			so using "debounce" method .on("input", => {})
	------ logic -------
			on every input 'debounce' resets
			new 'setTimeout' / 'debounce'  starts
			it user stops typing for a while then ajax fires to save the value


## Example : save a input fields value via ajax call, ajax don't fire untill user stops writing
```
    let titleTimer = null;
		let lastSavedTitle = null;

		$card.find(".admin-note-title")
			.on("input", function () {
				const $input = $(this);
				const newVal = $input.val();

				// Reset debounce timer
				clearTimeout(titleTimer);

				titleTimer = setTimeout(function () {
					// Skip if title didn't change
					if (newVal === lastSavedTitle) return;

					saveTitle($input);
				}, 500);  // adjust delay as needed
			})

			// Pressing Enter → blur → triggers save
			.on("keydown", function (e) {
				if (e.key === "Enter") {
					e.preventDefault();
					$(this).blur();
				}
			})

			// On blur — save immediately
			.on("blur", function () {
				const $input = $(this);
				const newVal = $input.val();

				clearTimeout(titleTimer); // Cancel pending debounce

				if (newVal !== lastSavedTitle) {
					saveTitle($input);
				}
			});


		// AJAX SAVE FUNCTION
		function saveTitle($input) {
			const newVal = $input.val();

			postAjax({
				action: "admin_notes_save_title",
				note_id: noteID,
				nonce: AdminNotes.nonce,
				title: newVal,
			});

			lastSavedTitle = newVal; // cache last saved value
		}
```

### Code example ot 3 of them :
```
// ============================
// Reusable Timing Helpers (jQuery version)
// ============================

// 1️⃣ Debounce: run after event stops firing
$.debounce = function(fn, delay = 300) {
  let timer = null;
  return function(...args) {
    clearTimeout(timer);
    timer = setTimeout(() => fn.apply(this, args), delay);
  };
};

// 2️⃣ Throttle: run at most once every limit ms
$.throttle = function(fn, limit = 200) {
  let waiting = false;
  return function(...args) {
    if (!waiting) {
      fn.apply(this, args);
      waiting = true;
      setTimeout(() => waiting = false, limit);
    }
  };
};

// 3️⃣ requestAnimationFrame helper: for UI updates
$.rAFLoop = function(fn) {
  let running = false;
  function loop() {
    running = true;
    fn();
    requestAnimationFrame(loop);
  }
  return {
    start: () => { if(!running) loop(); },
    stop: () => { running = false; }
  };
};

// ============================
// Usage Examples (jQuery)
// ============================

// Debounce example (input save)
const saveDebounced = $.debounce(function($input) {
  $.post(ajaxurl, { action: 'save', value: $input.val() });
}, 500);

// Throttle example (drag position save)
const saveThrottled = $.throttle(function($note) {
  const pos = $note.position();
  $.post(ajaxurl, { action: 'save_position', top: pos.top, left: pos.left });
}, 200);

// requestAnimationFrame example (smooth animation)
const anim = $.rAFLoop(function() {
  // animate something
});
// anim.start();
// anim.stop();
```
