<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h1>
                <i class="fa fa-euro"></i>
                <?php echo $app->t($currency->getId() ? 'currencyEdit' : 'currencyNew'); ?>
            </h1>
        </div>
        <div class="heading-elements">
            <div class="heading-btn-group">
                <a href="#" data-form-submit="form" data-form-param="apply" class="btn btn-icon-block btn-link-success">
                    <i class="fa fa-save"></i>
                    <span>{{ t('apply') }}</span>
                </a>
                <a href="#" data-form-submit="form" data-form-param="save" class="btn btn-icon-block btn-link-success">
                    <i class="fa fa-save"></i>
                    <span>{{ t('save') }}</span>
                </a>
                <a href="#" class="btn btn-icon-block btn-link-danger app-history-back">
                    <i class="fa fa-remove"></i>
                    <span>{{ t('cancel') }}</span>
                </a>
            </div>
        </div>
        <div class="heading-elements-toggle">
            <i class="fa fa-ellipsis-h"></i>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ createUrl() }}"><i class="fa fa-home"> </i>Verone</a></li>
            <li><a href="{{ createUrl('Currency', 'Currency', 'index') }}">{{ t('modNameCurrency') }}</a></li>
            @if $currency->getId()
                <li class="active"><a href="{{ createUrl('Currency', 'Currency', 'edit', [ 'id' => $currency->getId() ]) }}">{{ t('currencyEdit') }}</a></li>
            @else
                <li class="active"><a href="{{ createUrl('Currency', 'Currency', 'add') }}">{{ t('currencyNew') }}</a></li>
            @endif
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo $app->createUrl('Currency', 'Currency', $currency->getId() ? 'update' : 'save'); ?>" method="post" id="form" class="form-validation">
                <input type="hidden" name="id" value="{{ $currency->getId() }}" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{ t('basicInformations') }}</div>
                            <div class="panel-body">
                                @if ! $currency->getId()
                                    <?php $helper = $app->get('helper.currency'); ?>
                                    <div class="form-group">
                                        <label for="currency" class="control-label">{{ t('currency') }}</label>
                                        <select class="form-control" type="text" id="currency" name="currency">
                                            @foreach $helper->available()
                                                @if ! $helper->exists($item->code)
                                                    <option value="{{ $item->code }}">{{ $item->name }} - {{ $item->symbol }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="rate" class="control-label">{{ t('currencyExchangeRate') }}</label>
                                    <input class="form-control required" type="text" id="rate" name="rate" value="{{ $currency->getRate() }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
