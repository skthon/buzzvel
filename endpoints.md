# Endpoints

## Creates a new task: POST https://skthon.online/api/tasks/
```
Request:
curl --location "https://skthon.online/api/tasks/" \
--header "Authorization: Bearer 1|FlufuRPXR5q95TbZFrZ68V9XxDpiK0b9PPa5QSFw" \
--form "attachments[]=@\"/Users/sai/Downloads/2023 - Back-End Developer Test.pdf\"" \
--form "attachments[]=@\"/Users/sai/Downloads/Saikiran_Aug2023.pdf\"" \
--form "title=\"Finish buzzvel \"" \
--form "description=\"Buzzvel test consists of creating api endpoints for keeping track of tasks\""

Response:
{
    "data": {
        "id": "99f0c965-4f3d-4764-a54c-0bbaa6a056ee",
        "title": "Finish buzzvel",
        "description": "Buzzvel test consists of creating api endpoints for keeping track of tasks",
        "is_completed": false,
        "attachments": [
            {
                "id": "99f0c965-5530-4bf1-a027-468ba2d44a11",
                "filename": "2023 - Back-End Developer Test.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c965-5530-4bf1-a027-468ba2d44a11.pdf",
                "created_at": "2023-08-21T05:08:20.000000Z"
            },
            {
                "id": "99f0c966-3fb3-441a-ba06-61f9c3d321cf",
                "filename": "Saikiran_Aug2023.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c966-3fb3-441a-ba06-61f9c3d321cf.pdf",
                "created_at": "2023-08-21T05:08:21.000000Z"
            }
        ],
        "completed_at": null,
        "deleted_at": null,
        "created_at": "2023-08-21T05:08:20.000000Z",
        "updated_at": "2023-08-21T05:08:20.000000Z"
    },
    "code": 201
}
```
## Update an existing task: POST https://skthon.online/api/tasks/{task_uuid}
```
Request:
curl --location "https://skthon.online/api/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee" \
--header "Authorization: Bearer 1|FlufuRPXR5q95TbZFrZ68V9XxDpiK0b9PPa5QSFw" \
--form "_method=\"PUT\"" \
--form "attachments[]=@\"/Users/sai/Downloads/2023 - Back-End Developer Test.pdf\"" \
--form "attachments[]=@\"/Users/sai/Downloads/Saikiran_Aug2023.pdf\"" \
--form "title=\"Finish buzzvel updated\"" \
--form "description=\"Buzzvel test consists of creating api endpoints for keeping track of tasks\"" \
--form "is_completed=\"1\""

Response:
{
    "data": {
        "id": "99f0c965-4f3d-4764-a54c-0bbaa6a056ee",
        "title": "Finish buzzvel updated",
        "description": "Buzzvel test consists of creating api endpoints for keeping track of tasks",
        "is_completed": true,
        "attachments": [
            {
                "id": "99f0c965-5530-4bf1-a027-468ba2d44a11",
                "filename": "2023 - Back-End Developer Test.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c965-5530-4bf1-a027-468ba2d44a11.pdf",
                "created_at": "2023-08-21T05:08:20.000000Z"
            },
            {
                "id": "99f0c966-3fb3-441a-ba06-61f9c3d321cf",
                "filename": "Saikiran_Aug2023.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c966-3fb3-441a-ba06-61f9c3d321cf.pdf",
                "created_at": "2023-08-21T05:08:21.000000Z"
            },
            {
                "id": "99f0c9ea-b1a3-4eb5-aba6-3afcb8c17d30",
                "filename": "2023 - Back-End Developer Test.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c9ea-b1a3-4eb5-aba6-3afcb8c17d30.pdf",
                "created_at": "2023-08-21T05:09:48.000000Z"
            },
            {
                "id": "99f0c9eb-05c0-4abc-9896-a8dade029fcd",
                "filename": "Saikiran_Aug2023.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c9eb-05c0-4abc-9896-a8dade029fcd.pdf",
                "created_at": "2023-08-21T05:09:48.000000Z"
            }
        ],
        "completed_at": "2023-08-21T05:09:48.000000Z",
        "deleted_at": null,
        "created_at": "2023-08-21T05:08:20.000000Z",
        "updated_at": "2023-08-21T05:09:48.000000Z"
    }
}
```

## List all tasks: GET https://skthon.online/api/tasks/
```
Request:
curl --location "https://skthon.online/api/tasks/" \
--header "Authorization: Bearer 1|FlufuRPXR5q95TbZFrZ68V9XxDpiK0b9PPa5QSFw"

Response:
{
    "data": [
        {
            "id": "99f0c965-4f3d-4764-a54c-0bbaa6a056ee",
            "title": "Finish buzzvel updated",
            "description": "Buzzvel test consists of creating api endpoints for keeping track of tasks",
            "is_completed": true,
            "attachments": [
                {
                    "id": "99f0c965-5530-4bf1-a027-468ba2d44a11",
                    "filename": "2023 - Back-End Developer Test.pdf",
                    "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c965-5530-4bf1-a027-468ba2d44a11.pdf",
                    "created_at": "2023-08-21T05:08:20.000000Z"
                },
                {
                    "id": "99f0c966-3fb3-441a-ba06-61f9c3d321cf",
                    "filename": "Saikiran_Aug2023.pdf",
                    "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c966-3fb3-441a-ba06-61f9c3d321cf.pdf",
                    "created_at": "2023-08-21T05:08:21.000000Z"
                },
                {
                    "id": "99f0c9ea-b1a3-4eb5-aba6-3afcb8c17d30",
                    "filename": "2023 - Back-End Developer Test.pdf",
                    "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c9ea-b1a3-4eb5-aba6-3afcb8c17d30.pdf",
                    "created_at": "2023-08-21T05:09:48.000000Z"
                },
                {
                    "id": "99f0c9eb-05c0-4abc-9896-a8dade029fcd",
                    "filename": "Saikiran_Aug2023.pdf",
                    "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c9eb-05c0-4abc-9896-a8dade029fcd.pdf",
                    "created_at": "2023-08-21T05:09:48.000000Z"
                }
            ],
            "completed_at": "2023-08-21T05:09:48.000000Z",
            "deleted_at": null,
            "created_at": "2023-08-21T05:08:20.000000Z",
            "updated_at": "2023-08-21T05:09:48.000000Z"
        }
    ],
    "code": 200
}
```

## Show details of specific task: GET https://skthon.online/api/tasks/{task_uuid}
```
Request:
curl --location "https://skthon.online/api/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee" \
--header "Authorization: Bearer 1|FlufuRPXR5q95TbZFrZ68V9XxDpiK0b9PPa5QSFw"

Response:
{
    "data": {
        "id": "99f0c965-4f3d-4764-a54c-0bbaa6a056ee",
        "title": "Finish buzzvel updated",
        "description": "Buzzvel test consists of creating api endpoints for keeping track of tasks",
        "is_completed": true,
        "attachments": [
            {
                "id": "99f0c965-5530-4bf1-a027-468ba2d44a11",
                "filename": "2023 - Back-End Developer Test.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c965-5530-4bf1-a027-468ba2d44a11.pdf",
                "created_at": "2023-08-21T05:08:20.000000Z"
            },
            {
                "id": "99f0c966-3fb3-441a-ba06-61f9c3d321cf",
                "filename": "Saikiran_Aug2023.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c966-3fb3-441a-ba06-61f9c3d321cf.pdf",
                "created_at": "2023-08-21T05:08:21.000000Z"
            },
            {
                "id": "99f0c9ea-b1a3-4eb5-aba6-3afcb8c17d30",
                "filename": "2023 - Back-End Developer Test.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c9ea-b1a3-4eb5-aba6-3afcb8c17d30.pdf",
                "created_at": "2023-08-21T05:09:48.000000Z"
            },
            {
                "id": "99f0c9eb-05c0-4abc-9896-a8dade029fcd",
                "filename": "Saikiran_Aug2023.pdf",
                "url": "https://skthon.online/storage/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee/99f0c9eb-05c0-4abc-9896-a8dade029fcd.pdf",
                "created_at": "2023-08-21T05:09:48.000000Z"
            }
        ],
        "completed_at": "2023-08-21T05:09:48.000000Z",
        "deleted_at": null,
        "created_at": "2023-08-21T05:08:20.000000Z",
        "updated_at": "2023-08-21T05:09:48.000000Z"
    },
    "code": 200
}
```

## Deletes an existing task: DELETE https://skthon.online/api/tasks/{task_uuid}
```
Request:
curl --location --request DELETE "https://skthon.online/api/tasks/99f0c965-4f3d-4764-a54c-0bbaa6a056ee" \
--header "Authorization: Bearer 1|FlufuRPXR5q95TbZFrZ68V9XxDpiK0b9PPa5QSFw"

Response:
{
    "code": 200,
    "message": "Deleted successfully"
}
```


