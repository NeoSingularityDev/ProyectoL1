@extends('layout')

@section('title', 'Alumnos')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Alumnos</h1>
            <p class="mt-1 text-sm text-slate-500">Administración de alumnos registrados</p>
        </div>
        <button onclick="openCreate()"
            class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-indigo-700">
            + Nuevo alumno
        </button>
    </div>

    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('felicitacion'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('felicitacion') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold">No se pudo guardar el alumno:</p>
            <ul class="mt-1 list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col gap-3 sm:flex-row">
        <input id="searchInput" type="text" placeholder="Buscar por matrícula, nombre o correo..."
            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">

        <select id="statusFilter"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-indigo-500">
            <option value="todos">Todos los estados</option>
            <option value="activo">Activos</option>
            <option value="inactivo">Inactivos</option>
        </select>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Matrícula</th>
                        <th class="px-5 py-4">Alumno</th>
                        <th class="px-5 py-4">Edad</th>
                        <th class="px-5 py-4">Correo</th>
                        <th class="px-5 py-4">Estado</th>
                        <th class="px-5 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody id="alumnosTable" class="divide-y divide-slate-100">
                    @forelse($alumnos as $alumno)
                        <tr class="alumno-row hover:bg-slate-50"
                            data-search="{{ strtolower($alumno->matricula.' '.$alumno->nombre.' '.$alumno->apellido.' '.$alumno->email) }}"
                            data-status="{{ $alumno->activo ? 'activo' : 'inactivo' }}">
                            <td class="px-5 py-4 font-medium text-slate-700">
                                {{ $alumno->matricula }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $alumno->nombre }} {{ $alumno->apellido }}
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $alumno->age }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $alumno->email }}</td>
                            <td class="px-5 py-4">
                                @if($alumno->activo)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Activo</span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <button
                                        onclick="openEdit(this)"
                                        data-id="{{ $alumno->id }}"
                                        data-matricula="{{ $alumno->matricula }}"
                                        data-nombre="{{ $alumno->nombre }}"
                                        data-apellido="{{ $alumno->apellido }}"
                                        data-age="{{ $alumno->age }}"
                                        data-email="{{ $alumno->email }}"
                                        class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                        Editar
                                    </button>

                                    <form action="/alumnos/{{ $alumno->id }}/activo" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="rounded-md px-3 py-1.5 text-xs font-semibold {{ $alumno->activo ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                            {{ $alumno->activo ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>

                                    <button
                                        onclick="openDelete('{{ $alumno->id }}', '{{ addslashes($alumno->nombre.' '.$alumno->apellido) }}')"
                                        class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                                No hay alumnos registrados.
                            </td>
                        </tr>
                    @endforelse
                    <tr id="emptySearch" class="hidden">
                        <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                            No se encontraron alumnos con esos filtros.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-5 py-3 text-xs text-slate-500">
            Total de alumnos: {{ $alumnos->count() }}
        </div>
    </div>
</div>

<dialog id="alumnoDialog" class="w-full max-w-xl rounded-xl p-0 shadow-2xl backdrop:bg-slate-900/50">
    <form id="alumnoForm" method="POST" class="p-6">
        @csrf
        <input id="formMethod" type="hidden" name="_method" value="POST">

        <div class="mb-6 flex items-center justify-between">
            <h2 id="dialogTitle" class="text-xl font-bold text-slate-900">Nuevo alumno</h2>
            <button type="button" onclick="closeDialog('alumnoDialog')"
                class="rounded-lg px-2 py-1 text-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700">
                +
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Matrícula</label>
                <input name="matricula" id="matricula" required maxlength="255"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
                <input name="nombre" id="nombre" required maxlength="255"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Apellido</label>
                <input name="apellido" id="apellido" required maxlength="255"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Edad</label>
                <input name="age" id="age" type="number" min="1" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Correo electrónico</label>
                <input name="email" id="email" type="email" required maxlength="255"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeDialog('alumnoDialog')"
                class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancelar
            </button>
            <button type="submit"
                class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Guardar
            </button>
        </div>
    </form>
</dialog>

<dialog id="deleteDialog" class="w-full max-w-md rounded-xl p-0 shadow-2xl backdrop:bg-slate-900/50">
    <form id="deleteForm" method="POST" class="p-6">
        @csrf
        @method('DELETE')
        <h2 class="text-xl font-bold text-slate-900">Eliminar alumno</h2>
        <p class="mt-3 text-sm text-slate-600">
            ¿Estás seguro de que deseas eliminar a <strong id="deleteName"></strong>?
            Esta acción no se puede deshacer.
        </p>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeDialog('deleteDialog')"
                class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancelar
            </button>
            <button type="submit"
                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                Eliminar
            </button>
        </div>
    </form>
</dialog>
@endsection

@push('scripts')
<script>
    const alumnoDialog = document.getElementById('alumnoDialog');
    const deleteDialog = document.getElementById('deleteDialog');
    const alumnoForm = document.getElementById('alumnoForm');

    function closeDialog(id) {
        document.getElementById(id).close();
    }

    function openCreate() {
        alumnoForm.action = '/alumnos';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('dialogTitle').textContent = 'Nuevo alumno';
        alumnoForm.reset();
        alumnoDialog.showModal();
    }

    function openEdit(button) {
        const id = button.dataset.id;

        alumnoForm.action = `/alumnos/${id}`;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('dialogTitle').textContent = 'Editar alumno';

        document.getElementById('matricula').value = button.dataset.matricula;
        document.getElementById('nombre').value = button.dataset.nombre;
        document.getElementById('apellido').value = button.dataset.apellido;
        document.getElementById('age').value = button.dataset.age;
        document.getElementById('email').value = button.dataset.email;

        alumnoDialog.showModal();
    }

    function openDelete(id, nombre) {
        document.getElementById('deleteForm').action = `/alumnos/${id}`;
        document.getElementById('deleteName').textContent = nombre;
        deleteDialog.showModal();
    }

    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const rows = document.querySelectorAll('.alumno-row');
    const emptySearch = document.getElementById('emptySearch');

    function filterRows() {
        const search = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        let visible = 0;

        rows.forEach(row => {
            const matchesSearch = row.dataset.search.includes(search);
            const matchesStatus = status === 'todos' || row.dataset.status === status;
            const show = matchesSearch && matchesStatus;

            row.classList.toggle('hidden', !show);

            if (show) visible++;
        });

        emptySearch.classList.toggle('hidden', visible > 0);
    }

    searchInput.addEventListener('input', filterRows);
    statusFilter.addEventListener('change', filterRows);
</script>
@endpush