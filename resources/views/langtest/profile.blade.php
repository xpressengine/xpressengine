<ul>
    @foreach ( $keys as $currKey => $temp )
        <li>
            @if ( $currKey == $key )
                {{ $currKey }}
                        <table border="1">
                            <tr>
                                <td><b>namespace</b></td>
                                <td><b>item</b></td>
                                <td><b>locale</b></td>
                                <td><b>value</b></td>
                            </tr>
                        <?php
                        foreach ( $data as $namespace => $ns ) {
                            foreach ( $ns as $item => $i ) {
                                foreach ( $i as $locale => $value ) {
                                    $namespace = $namespace ?: '(unknown)';
                                    $item = $item ?: '(unknown)';
                                    echo "<tr><td>{$namespace}</td><td>{$item}</td><td>{$locale}</td><td>$value</td></tr>";
                                }
                            }
                        }
                        ?>
                        </table>
            @else
                <a href="{{ route('manage.lang.test.profile', base64_encode($currKey)) }}">{{ $currKey }}</a>
            @endif
        </li>
    @endforeach
</ul>