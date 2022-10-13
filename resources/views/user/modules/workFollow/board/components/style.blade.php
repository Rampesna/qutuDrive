<link href="{{ asset('assets/plugins/custom/jkanban/jkanban.bundle.css') }}" rel="stylesheet" type="text/css" />

<style>
    .showTaskHeaderTitleBackground{
        background: rgb(255,139,0);
        background: linear-gradient(90deg, rgba(255,139,0,1) 0%, rgba(181,77,0,1) 100%);
    }

    .kanban-board-header {
        margin-bottom: -20px;
    }

    .kanban-container .kanban-board {
        float: none;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        margin-bottom: 1.25rem;
        margin-right: 1.25rem !important;
        background-color: transparent;
        border-radius: 0.42rem;
    }

    .kanban-container .kanban-board .kanban-drag .kanban-item {
        border-radius: 1rem;
        -webkit-box-shadow: 0px 0px 13px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0px 0px 13px 0px rgba(0, 0, 0, 0.05);
    }

    .offcanvas.offcanvas-right {
        right: -900px;
        left: auto;
    }

    .opacity-60 {
        opacity: 60%;
    }
</style>
