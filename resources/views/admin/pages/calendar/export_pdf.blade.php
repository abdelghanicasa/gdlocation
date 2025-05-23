<h3>Liste des réservations</h3>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>État</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->title }}</td>
            <td>{{ $r->start }}</td>
            <td>{{ $r->end }}</td>
            <td>{{ $r->etat_reservation }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
