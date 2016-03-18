/*
 * Confirm the delete operation
 */
function confirmDelete() {
	if (confirm("Delete this item?")) {
		return true;
	} else {
		return false;
	}
}