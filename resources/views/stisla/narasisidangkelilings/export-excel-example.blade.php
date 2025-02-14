<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Tahun') }}</th>
      <th class="text-center">{{ __('Narasi') }}</th>
      <th class="text-center">{{ __('Foto') }}</th>
      <th class="text-center">{{ __('Dokumen') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->tahun }}</td>
        <td>{{ $item->narasi }}</td>
        <td>{{ $item->foto }}</td>
        <td>{{ $item->dokumen }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
