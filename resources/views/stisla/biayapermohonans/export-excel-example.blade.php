<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Biaya Pendaftaran') }}</th>
      <th class="text-center">{{ __('Biaya ATK / Administrasi') }}</th>
      <th class="text-center">{{ __('PNBP Panggilan') }}</th>
      <th class="text-center">{{ __('Materai') }}</th>
      <th class="text-center">{{ __('Redaksi') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->biaya_pendaftaran }}</td>
        <td>{{ $item->biaya_atk_administrasi }}</td>
        <td>{{ $item->pnbp_panggilan }}</td>
        <td>{{ $item->materai }}</td>
        <td>{{ $item->redaksi }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
