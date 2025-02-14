<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Judul') }}</th>
      <th class="text-center">{{ __('Nomor Peraturan') }}</th>
      <th class="text-center">{{ __('Tahun') }}</th>
      <th class="text-center">{{ __('Keterangan') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->judul }}</td>
        <td>{{ $item->nomor_peraturan }}</td>
        <td>{{ $item->tahun }}</td>
        <td>{{ $item->keterangan }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
