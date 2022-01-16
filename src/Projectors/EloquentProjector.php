<?php

namespace ProwectCMS\Core\Projectors;

use Illuminate\Database\Eloquent\SoftDeletes;
use ProwectCMS\Core\Events\Event;
use ProwectCMS\Core\Models\Model;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

abstract class EloquentProjector extends Projector
{
    private string $modelClass;
    private bool $hasSoftDeletes = false;

    public function __construct()
    {
        $this->modelClass = $this->getModelClass();
        $this->hasSoftDeletes = in_array(SoftDeletes::class, class_uses_recursive($this->modelClass), true);
    }

    abstract protected function getModelClass();

    protected function getQuery()
    {
        $query = $this->modelClass::query();
        if ($this->hasSoftDeletes) {
            $query->withTrashed();
        }

        return $query;
    }

    protected function restoreIfDeleted(Model $model)
    {
        if ($this->hasSoftDeletes) {
            if ($model->trashed()) {
                $model->restore();
            }
        }
    }

    protected function getModel()
    {
        return new $this->modelClass;
    }

    protected function executeCallback(Model $model, Event $event, callable $callback = null)
    {
        if (!is_null($callback)) {
            return call_user_func($callback, $model, $event);
        }
    }

    protected function onCreated(Event $event, callable $callback = null) : Model
    {
        $query = $this->getQuery();

        $model = $query->firstOrNew([
            $this->getModel()->getKeyName() => $event->aggregateRootUuid()
        ]);

        if (isset($event->attributes)) {
            $model->forceFill($event->attributes);
        }

        $this->executeCallback($model, $event, $callback);

        if ($model->usesTimestamps()) {
            $model->setCreatedAt($event->createdAt());
        }

        $model->save();

        $this->restoreIfDeleted($model);

        return $model;
    }

    protected function onUpdated(Event $event, callable $callback = null) : bool
    {
        $query = $this->getQuery();
        $model = $query->find($event->aggregateRootUuid());
        if ($model) {
            if (isset($event->attributes)) {
                $model->forceFill($event->attributes);
            }

            $this->executeCallback($model, $event, $callback);

            if ($model->usesTimestamps()) {
                $model->setUpdatedAt($event->createdAt());
            }

            $model->save();

            return true;
        }

        return false;
    }

    protected function onDeleted(Event $event, callable $callback = null) : bool
    {
        $query = $this->getQuery();
        $model = $query->find($event->aggregateRootUuid());
        if ($model) {
            $this->executeCallback($model, $event, $callback);

            if ($this->hasSoftDeletes) {
                $model->{$model->getDeletedAtColumn()} = $event->createdAt();
                $model->save();
            } else {
                $model->delete();
            }

            return true;
        }

        return false;
    }
}