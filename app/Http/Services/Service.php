<?php

declare(strict_types=1);

namespace App\Http\Services;

use Illuminate\Http\JsonResponse;

/**
 * Service
 */
class Service
{
    /**
     * Model::class
     */
    public $model;
    /**
     * @var array
     */
    public array $filters = [];
    /**
     * @var array
     */
    protected array $response = [
        'data' => array(),
        'status' => false,
        'code' => 'HTTP_OK',
        'message' => '',
    ];

    /**
     * @return mixed
     */
    public function findAll(): mixed
    {
        return $this->model::all();
    }

    /**
     * @param string $column
     * @param $value
     * @return mixed
     */
    public function findBy(string $column, $value): mixed
    {
        return $this->model::where($column, $value);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->model::create($data)->fresh();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data): mixed
    {
        return $this->model::insert($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $item = $this->findById($id);
        $item->fill($data);
        $item->save();

        return $item->fresh();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id): mixed
    {
        return $this->model::find($id);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id) : void
    {
        $this->model::destroy($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function restore(int $id): mixed
    {
        $object = $this->findByIdWithTrashed($id);

        if ($object && method_exists($this->model, 'isSoftDelete')) {
            $object->restore($id);
            return $object;
        }

        return (object)[];
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findByIdWithTrashed(int $id): mixed
    {
        if (method_exists($this->model, 'isSoftDelete')) {
            return $this->model::withTrashed()->find($id);
        }

        return (object)[];
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @return JsonResponse
     */
    public function getJsonResponse(): JsonResponse
    {
        return response()->json($this->response, $this->getCode());
    }

    /**
     * @param mixed $data
     * @return void
     */
    public function setData(mixed $data): void
    {
        $this->response['data'] = $data;
    }

    /**
     * @param bool $status
     * @return void
     */
    public function setStatus(bool $status): void
    {
        $this->response['status'] = $status;
    }

    /**
     * @param int $code
     * @return void
     */
    public function setCode(int $code): void
    {
        $this->response['code'] = $code;
    }

    /**
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->response['message'] = $message;
    }

    /**
     * @param array $value
     * @return void
     */
    public function setCustomResponse(array $value): void
    {
        $this->response = array_merge($this->response, $value);
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->response['code'];
    }
}
