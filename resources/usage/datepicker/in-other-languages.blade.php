{{-- Dates, month and weekday names, the week's first day and digits follow the app locale (app()->getLocale()). For Arabic, Hebrew, Persian or Urdu, set dir="rtl" and the calendar mirrors, keyboard included. The picker's own labels are plain English in the component file; edit them there. --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}">

{{-- Or set them per picker: --}}
<x-widget.datepicker name="start_date" label="Datum" locale="de" :week-start="0" />
