<!DOCTYPE html>
<html lang="en">

<body>

    <!-- Categories Widget -->
    <div class="card my-4">
        <h5 class="card-header">Filter By Labels </h5>
        <div class="card-body">
            <div class="row">
                <div style="margin-left: 20px;">

                    <font size="2" color="grey">
                    <p>Click on a label once to filter the questions.
                       Click on it again to go back to the unfiltered list.</p>
                    </font>

                    <p>
                    <?php $arr_labels = [];?>
                    @if(count($label_data) > 0)
                        @foreach($label_data as $key => $data)
                            @if((!$data->labels) == "")

                                <!--Trim and take out duplicates in database rows (label,label)-->
                                <?php $parts = explode(',', $data->labels);
                                $trimed_parts = array_map('trim', $parts); $parts = array_unique($trimed_parts);?>

                                <!--take out duplicates in single labels-->
                                @foreach($parts as $label)
                                    @if( (!(in_array($label, $arr_labels))) || empty($arr_labels))
                                        <?php array_push($arr_labels, $label); ?>
                                    @endif
                                @endforeach

                            @endif
                        @endforeach
                    @endif

                    <!-- print labels-->

                        <!-- background_color_label = 1 means that a white label was clicked and 0 means a blue label was clicked-->
                        @foreach($arr_labels as $label1)
                            @if($background_color_label == 0)
                                <a href="#" class="filter_labels label-filtering-selected">{{$label1}}</a>
                            @elseif ($background_color_label == 1 && $label_clicked == $label1)
                                <a href="#" class="filter_labels label-filtering-selected" style="background: powderblue;">{{$label1}}</a>
                            @else
                                <a href="#" class="filter_labels label-filtering-selected">{{$label1}}</a>
                            @endif
                        @endforeach

                    </p>

                </div>
            </div>
        </div>
    </div>

</body>
</html>