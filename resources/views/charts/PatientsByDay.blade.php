 <canvas id="myChart" width="100%" height="100%"></canvas>
                    <script>
                    let patients_count = @json($patients_count);
                    let hospital_names = Object.keys(patients_count);
                    let patients_count_per_day = [];
                    let all_days = @json($days);
                    // extract patients_count_per_day keys from patients_count array

                    all_days.sort();

                    const data = {
                        labels: all_days,
                        // dataset is patients_count_per_day for each hospital
                        datasets: [
                            @foreach($patients_count as $hospital_name => $hospital_data)
                            @php
                                $hospital_patients_count_per_day = $hospital_data['patients_count_per_day'];
                                // if a day in all_days array is not in hospital_patients_count_per_day array, add 0 to it
                                for($i = 0; $i < count($days); $i++) {
                                    if(!array_key_exists($days[$i], $hospital_patients_count_per_day->toArray())) {
                                        $hospital_patients_count_per_day[$days[$i]] = 0;
                                    }
                                }
                                // sort hospital_patients_count_per_day array by keys
                                $hospital_patients_count_per_day = $hospital_patients_count_per_day->all();
                                ksort($hospital_patients_count_per_day);
                            @endphp
                                {
                                    label: '{{ $hospital_name }}',
                                    data: Object.values(@json($hospital_patients_count_per_day)),
                                    // generate backgroundColor based on hospital name in form of hex color
                                    backgroundColor: '#' + '{{ str_pad(dechex(crc32($hospital_name)), 6, '0', STR_PAD_LEFT) }}',
                                    borderColor: '#' + '{{ str_pad(dechex(crc32($hospital_name)), 6, '0', STR_PAD_LEFT) }}',
                                        borderWidth: 1
                                },
                            @endforeach
                        ]
                    };

                    const ctx = document.getElementById('myChart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data: data,
                        options: {
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks:{
                                        display:true,
                                        callback: function(value, index, values) {
                                            if(Math.floor(value) === value) {
                                                return value;
                                            }
                                        }
                                    }
                                }
                            },

                        }
                    });
                </script>
