### Notes
  ## use "debounce" method to reduce ajax calls (increase ajax performance)
			saving data .on("blur", => {} ) is not enough, as it may not fire always,
			so using "debounce" method .on("input", => {})
	------ logic -------
			on every input 'debounce' resets
			new 'setTimeout' / 'debounce'  starts
			it user stops typing for a while then ajax fires to save the value


## Example : save a input fields value via ajax call, ajax dont' fire untill user stops writing
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

