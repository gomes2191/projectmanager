<?php
    if (!defined('ABSPATH')){
        exit;
    }
    
    // Carrega todos os métodos do modelo
    $modelo->validate_register_form();
    $modelo->get_register_form(chk_array($parametros, 1));
    $modelo->del_user($parametros);
    
    
?>
    

<div class="row-fluid">
    
    <div ng-controller="KitchenSinkCtrl as vm">
  <h2 class="text-center">{{ vm.calendarTitle }}</h2>

  <div class="row">

    <div class="col-md-6 text-center">
      <div class="btn-group">

        <button
          class="btn btn-primary"
          mwl-date-modifier
          date="vm.viewDate"
          decrement="vm.calendarView">
          Previous
        </button>
        <button
          class="btn btn-default"
          mwl-date-modifier
          date="vm.viewDate"
          set-to-today>
          Today
        </button>
        <button
          class="btn btn-primary"
          mwl-date-modifier
          date="vm.viewDate"
          increment="vm.calendarView">
          Next
        </button>
      </div>
    </div>

    <br class="visible-xs visible-sm">

    <div class="col-md-6 text-center">
      <div class="btn-group">
        <label class="btn btn-primary" ng-model="vm.calendarView" uib-btn-radio="'year'">Ano</label>
        <label class="btn btn-primary" ng-model="vm.calendarView" uib-btn-radio="'month'">Mês</label>
        <label class="btn btn-primary" ng-model="vm.calendarView" uib-btn-radio="'week'">Semana</label>
        <label class="btn btn-primary" ng-model="vm.calendarView" uib-btn-radio="'day'">Hoje</label>
      </div>
    </div>

  </div>

  <br>

  <mwl-calendar
    events="vm.events"
    view="vm.calendarView"
    view-title="vm.calendarTitle"
    view-date="vm.viewDate"
    on-event-click="vm.eventClicked(calendarEvent)"
    on-event-times-changed="vm.eventTimesChanged(calendarEvent); calendarEvent.startsAt = calendarNewEventStart; calendarEvent.endsAt = calendarNewEventEnd"
    cell-is-open="vm.isCellOpen"
    day-view-start="06:00"
    day-view-end="22:59"
    day-view-split="30"
    cell-modifier="vm.modifyCell(calendarCell)">
  </mwl-calendar>

  <br><br><br>

  <h3 id="event-editor">
    Edit events
    <button
      class="btn btn-primary pull-right"
      ng-click="vm.addEvent()">
      Adicionar consulta
    </button>
    <div class="clearfix"></div>
  </h3>

  <table class="table table-bordered">

    <thead>
      <tr>
        <th>Title</th>
        <th>Primary color</th>
        <th>Secondary color</th>
        <th>Starts at</th>
        <th>Ends at</th>
        <th>Remove</th>
      </tr>
    </thead>

    <tbody>
      <tr ng-repeat="event in vm.events track by $index">
        <td>
          <input
            type="text"
            class="form-control"
            ng-model="event.title">
        </td>
        <td>
          <input class="form-control" colorpicker type="text" ng-model="event.color.primary">
        </td>
        <td>
          <input class="form-control" colorpicker type="text" ng-model="event.color.secondary">
        </td>
        <td>
          <p class="input-group" style="max-width: 250px">
            <input
              type="text"
              class="form-control"
              readonly
              uib-datepicker-popup="dd MMMM yyyy"
              ng-model="event.startsAt"
              is-open="event.startOpen"
              close-text="Close" >
            <span class="input-group-btn">
              <button
                type="button"
                class="btn btn-default"
                ng-click="vm.toggle($event, 'startOpen', event)">
                <i class="glyphicon glyphicon-calendar"></i>
              </button>
            </span>
          </p>
          <div
            uib-timepicker
            ng-model="event.startsAt"
            hour-step="1"
            minute-step="15"
            show-meridian="true">
          </div>
        </td>
        <td>
          <p class="input-group" style="max-width: 250px">
            <input
              type="text"
              class="form-control"
              readonly
              uib-datepicker-popup="dd MMMM yyyy"
              ng-model="event.endsAt"
              is-open="event.endOpen"
              close-text="Close">
            <span class="input-group-btn">
              <button
                type="button"
                class="btn btn-default"
                ng-click="vm.toggle($event, 'endOpen', event)">
                <i class="glyphicon glyphicon-calendar"></i>
              </button>
            </span>
          </p>
          <div
            uib-timepicker
            ng-model="event.endsAt"
            hour-step="1"
            minute-step="15"
            show-meridian="true">
          </div>
        </td>
        <td>
          <button
            class="btn btn-danger"
            ng-click="vm.events.splice($index, 1)">
            Delete
          </button>
        </td>
      </tr>
    </tbody>

  </table>
</div>
   

</div><!-- /fluid -->




<div class="modal-header">
        <h3 class="modal-title">Event action occurred!</h3>
      </div>
      <div class="modal-body">
        <p>Action:
        <pre>{{ vm.action }}</pre>
        </p>
        <p>Event:
        <pre>{{ vm.event | json }}</pre>
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" ng-click="$close()">OK</button>
      </div>
