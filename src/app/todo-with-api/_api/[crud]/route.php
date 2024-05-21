<?php

use Lib\Prisma\Classes\Prisma;

$prisma = new Prisma();

$crudRoute = $dynamicRouteParams['crud'];

function todos()
{
    $prisma = new Prisma();
    return $prisma->todo->findMany([], true);
}

if ($crudRoute === 'create') {
    $prisma->todo->create([
        'data' => [
            'title' => $params->title
        ]
    ]);
}

if ($crudRoute === 'completed') {
    $prisma->todo->update([
        'where' => [
            'id' => $params->id
        ],
        'data' => [
            'completed' => isset($params->completed) ? true : false
        ]
    ]);
}

if ($crudRoute === 'title') {
    $prisma->todo->update([
        'where' => [
            'id' => $params->id
        ],
        'data' => [
            'title' => $params->title
        ]
    ]);
}

if ($crudRoute === 'delete') {
    $prisma->todo->delete([
        'where' => [
            'id' => $params->id
        ]
    ]);
}

?>

<?php foreach (todos() as $todo) : ?><div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 rounded-md p-2">
        <div class="flex items-center">
            <input type="checkbox" class="mr-2 text-blue-500 focus:ring-blue-500 focus:ring-2 rounded" <?= $todo->completed ? 'checked' : '' ?> name="completed" hx-patch="/todo-with-api/_api/completed" hx-vals='{"id": "<?= $todo->id ?>"}' hx-target="#todos" />
            <span class="<?= $todo->completed ? 'line-through' : '' ?> text-gray-500 dark:text-gray-400"><?= $todo->title ?></span>
        </div>
        <div class="flex items-center space-x-2">
            <button class="text-yellow-500 hover:text-yellow-600" hx-trigger="click" hx-vals='{"targets": [{"id": "edit-title", "value": "<?= $todo->title ?>"}, {"id": "edit-id", "value": "<?= $todo->id ?>"}], "attributes": [{"id": "edit-form", "attributes": {"class": "-hidden flex"}}, {"id": "create-form", "attributes": {"class": "-flex hidden"}}], "swaps": [{"id": "create-form", "attributes": {"class": "-hidden flex"}}, {"id": "edit-form", "attributes": {"class": "-flex hidden"}}]}'>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <path d="M20 5H9l-7 7 7 7h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2Z"></path>
                    <line x1="18" x2="12" y1="9" y2="15"></line>
                    <line x1="12" x2="18" y1="9" y2="15"></line>
                </svg>
            </button>
            <button class="text-red-500 hover:text-red-600" hx-delete="/todo-with-api/_api/delete" hx-vals='{"id":"<?= $todo->id ?>"}' hx-target="#todos" hx-confirm="Are you sure you wish to delete your account?">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                </svg>
            </button>
        </div>
    </div>
<?php endforeach; ?>