<div class="flex flex-col items-center justify-center h-screen bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Todo List</h1>
        <form id="edit-form" class="items-center mb-4 hidden" hx-patch="<?= $pathname . '/_api/title' ?>" hx-target="#todos" hx-on="htmx:afterRequest: this.reset()">
            <input type="hidden" name="id" id="edit-id">
            <input id="edit-title" type="text" placeholder="Edit todo..." class="flex-1 px-4 py-2 rounded-l-md bg-gray-100 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500" name="title" />
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-r-md">Edit</button>
        </form>
        <form id="create-form" class="flex items-center mb-4" hx-post="<?= $pathname . '/_api/create' ?>" hx-target="#todos" hx-on="htmx:afterRequest: this.reset()">
            <input id="create-title" type="text" placeholder="Add a new todo..." class="flex-1 px-4 py-2 rounded-l-md bg-gray-100 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500" name="title" />
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-r-md">Add</button>
        </form>
        <div id="todos" class="space-y-2" hx-get="<?= $pathname . '/_api/read' ?>" hx-trigger="load"></div>
    </div>
</div>