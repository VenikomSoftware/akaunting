<?php

namespace App\View\Components;

use App\Abstracts\View\Component;
use App\Traits\DateTime;
use App\Traits\Translations;
use Illuminate\Support\Str;

class SearchString extends Component
{
    use DateTime, Translations;

    public $filters;

    public $filtered;

    /** string */
    public $model;

    public $skip_columns = [
        'created_at',
        'updated_at',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $model = '', $filters = false, $filtered = false)
    {
        $this->model = $model;
        $this->filters = $filters;
        $this->filtered = $filtered;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if (empty($this->filters)) {
            $search_string = config('search-string');

            $this->filters = [];

            if (! empty($search_string[$this->model])) {
                $columns = $search_string[$this->model]['columns'];

                foreach ($columns as $column => $options) {
                    // This column skip for filter
                    if (! empty($options['searchable'])) {
                        continue;
                    }

                    // This column skip for filter
                    if (in_array($column, $this->skip_columns)) {
                        continue;
                    }

                    if (! is_array($options)) {
                        $column = $options;
                    }

                    if (! $this->isFilter($column, $options)) {
                        continue;
                    }

                    $this->filters[] = [
                        'key' => $this->getFilterKey($column, $options),
                        'value' => $this->getFilterName($column, $options),
                        'type' => $this->getFilterType($options),
                        'url' => $this->getFilterUrl($column, $options),
                        'values' => $this->getFilterValues($column, $options),
                    ];
                }
            }
        }

        return view('components.search-string');
    }

    protected function isFilter($column, $options)
    {
        $filter = true;

        if (empty($this->getFilterUrl($column, $options)) && (! isset($options['date']) && ! isset($options['boolean']) && ! isset($options['values']))) {
            $filter = false;
        }

        return $filter;
    }

    protected function getFilterKey($column, $options)
    {
        if (isset($options['key'])) {
            $column = $options['key'];
        }

        if (isset($options['relationship']) && isset($options['foreign_key']) && ! empty($options['foreign_key'])) {
            $column .= '.'.$options['foreign_key'];
        }

        if (isset($options['relationship']) && ! isset($options['foreign_key'])) {
            $column .= '.id';
        }

        return $column;
    }

    protected function getFilterName($column, $options)
    {
        if (strpos($column, '_id') !== false) {
            $column = str_replace('_id', '', $column);
        } elseif (strpos($column, '_code') !== false) {
            $column = str_replace('_code', '', $column);
        }

        if (! empty($options['translation']) && ! isset($options['boolean'])) {
            return $options['translation'];
        }

        if (! empty($options['key'])) {
            $column = $options['key'];
        }

        $plural = Str::plural($column, 2);

        if (strpos($this->model, 'Modules') !== false) {
            $module_class = explode('\\', $this->model);

            $prefix = Str::kebab($module_class[1]).'::';

            $translation_keys[] = $prefix.'general.';
            $translation_keys[] = $prefix.'search_string.columns.';
        }

        $translation_keys[] = 'general.';
        $translation_keys[] = 'search_string.columns.';

        foreach ($translation_keys as $translation_key) {
            if (trans_choice($translation_key.$plural, 1) !== $translation_key.$plural) {
                return trans_choice($translation_key.$plural, 1);
            }

            if (trans($translation_key.$column) !== $translation_key.$column) {
                return trans($translation_key.$column);
            }
        }

        return $column;
    }

    protected function getFilterType($options)
    {
        $type = 'select';

        if (isset($options['boolean'])) {
            $type = 'boolean';
        }

        if (isset($options['date'])) {
            $type = 'date';
        }

        return $type;
    }

    protected function getFilterUrl($column, $options)
    {
        $url = '';

        if (isset($options['boolean']) || isset($options['date'])) {
            return $url;
        }

        if (! empty($options['route'])) {
            if (is_array($options['route'])) {
                $url = route($options['route'][0], $options['route'][1]);
            } else {
                $url = route($options['route']);
            }
        } else {
            if (strpos($this->model, 'Modules') !== false) {
                $module_class = explode('\\', $this->model);

                $url .= Str::kebab($module_class[1]).'::';
            }

            if (strpos($column, '_id') !== false) {
                $column = str_replace('_id', '', $column);
            }

            $plural = Str::plural($column, 2);

            try {
                $url = route($url.$plural.'.index');
            } catch (\Exception $e) {
                $url = '';
            }
        }

        return $url;
    }

    protected function getFilterValues($column, $options)
    {
        $values = [];

        if (isset($options['boolean'])) {
            $values = [
                [
                    'key' => 0,
                    'value' => empty($options['translation']) ? trans('general.no') : $this->findTranslation($options['translation'][0], 1),
                ],
                [
                    'key' => 1,
                    'value' => empty($options['translation']) ? trans('general.yes') : $this->findTranslation($options['translation'][1], 1),
                ],
            ];
        } elseif (isset($options['values'])) {
            foreach ($options['values'] as $key => $value) {
                $values[$key] = $this->findTranslation($value, 1);
            }
        } elseif ($search = request()->get('search', false)) {
            $fields = explode(' ', $search);

            foreach ($fields as $field) {
                if (strpos($field, ':') === false) {
                    continue;
                }

                $filters = explode(':', $field);

                if ($filters[0] != $column) {
                    continue;
                }
            }
        }

        return $values;
    }
}
