<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Tanggal Sidang') }}</th>
      <th class="text-center">{{ __('Nama Pemohon') }}</th>
      <th class="text-center">{{ __('Tempat Sidang') }}</th>
      <th class="text-center">{{ __('Agenda Sidang') }}</th>
      <th class="text-center">{{ __('Hakim') }}</th>
      <th class="text-center">{{ __('Panitera Penggati') }}</th>
      <th class="text-center">{{ __('Nomor Perkara') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->tanggal_sidang }}</td>
        <td>{{ $item->nama_pemohon }}</td>
        <td>{{ $item->tempat_sidang }}</td>
        <td>{{ $item->agenda_sidang }}</td>
        <td>{{ $item->hakim }}</td>
        <td>{{ $item->panitera_pengganti }}</td>
        <td>{{ $item->nomor_perkara }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
