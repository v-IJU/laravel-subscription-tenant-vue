<?php

namespace App\Http\Livewire;

use Auth;
use cms\websitecms\Models\CmsSeviceModel;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CmsServiceTable extends LivewireTableComponent
{
    use WithPagination;

    public $showButtonOnHeader = false;

    public $showFilterOnHeader = false;

    public $paginationIsEnabled = true;

    public $buttonComponent = "cms_services.add-button";

    public $FilterComponent = [];

    protected $model = CmsSeviceModel::class;

    protected $listeners = [
        "refresh" => '$refresh',
        "changeFilter",
        "resetPage",
    ];

    public function resetPage($pageName = "page")
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData["current_page"] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum =
            count($rowsPropertyData["data"]) > 0
                ? $rowsPropertyData["current_page"]
                : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }

    public function changeFilter($param, $value)
    {
        $this->resetPage($this->getComputedPageName());
        $this->statusFilter = $value;
        $this->setBuilder($this->builder());
    }

    public function configure(): void
    {
        $this->setPrimaryKey("id")
            ->setDefaultSort("vendor.created_at", "desc")
            ->setQueryStringStatus(false);
        $this->setThAttributes(function (Column $column) {
            return [
                "class" => "",
            ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make("Service Name", "service_name")
                ->view("storevendor.columns.name")
                ->sortable()
                ->searchable(),

            Column::make("Created At", "created_at")
                ->view("storevendor.columns.created_at")
                ->sortable()
                ->searchable(),

            Column::make(__("messages.common.status"), "status")->view(
                "storevendor.columns.status"
            ),
        ];
    }

    public function builder(): Builder
    {
        /** @var Service $query */
        $query = VendorModel::where(
            "vendor.tenant_id",
            Auth::user()->tenant_id
        )->select("*");

        $query->when(isset($this->statusFilter), function (Builder $q) {
            if ($this->statusFilter == Service::ACTIVE) {
                $q->where("status", $this->statusFilter);
            }
            if ($this->statusFilter == 2) {
                $q->where("status", Service::INACTIVE);
            }
        });

        return $query;
    }
}
