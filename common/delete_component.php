<form method="POST" id="delete-form">
    <input type="hidden" name="action" value="delete">
    <button type="button" id="delete-button">[DELETE]</button>
</form>

<script>
    document.querySelector("#delete-button").addEventListener("click", () => {
        if (confirm("Are you sure you want to delete this item? This action is not reversible!")) {
            document.querySelector("#delete-form").submit()
        }
    })
</script>