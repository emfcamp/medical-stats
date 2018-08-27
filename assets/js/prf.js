// categoryLookup defined on page

$(document).ready(function() {
	// attach to change event of category dropdown
	$('#category').change(checkCategory);

	$('#prf').submit(validateCategorisation);
});


function checkCategory()
{
	options = [];
	if (typeof categoryLookup[$(this).val()] != "undefined") {
		options = categoryLookup[$(this).val()].severities;
	}
	setOptions('#severity', options);

	if (options.length < 2) {
		$('#severity').parent().parent().addClass('d-none');
	} else {
		$('#severity').parent().parent().removeClass('d-none');
	}

	if (options.length == 1) {
		console.log(options[0]);
		$('#severity').val(options[0]);
	}
}

function setOptions(selector, options)
{
	var select = $(selector)[0];

	// get rid of all options
	select.options.length = 0;

	// add the first (standard) one;
	select.add(new Option("Select...", "-"));

	for (var i = 0; i < options.length; i++) {
		select.add(new Option(options[i], options[i]));
	}
}

function validateCategorisation()
{
	var category = $('#category').val();
	var severity = $('#severity').val();

	if (category == "-") {
		msg = "You must select a category";
		return showError('prf', msg);
	} else {
		var severities = categoryLookup[category]['severities'];
		var found = false;
		for (var i = 0; i < severities.length; i++) {
			if (severities[i] == severity) {
				found = true;
			}
		}
		if (!found) {
			msg = "Invalid Category / Severity combination";
			return showError('prf', msg);
		}
	}

	return true
}

function showError(form, msg)
{
	removeErrors(form);
	$('#' + form).prepend('<p class="alert alert-danger">' + msg + '</p>');

	return false;
}

function removeErrors(form)
{
	$('#' + form + " .alert").remove();
}