<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
 

 
 
 
 
 
 
 
 
 
 
 
 
 <div>		<div class="moduletable">
					<script type="text/javascript">/*<![CDATA[*/function calc(){var Cccc=[[0.5,0.75,1,1.2,1.5,2,2.5,3,4,5,6,8,10,16,25,35,50,70,95,120],[11,15,17,20,23,26,30,34,41,46,50,62,80,100,140,170,215,270,330,385],[0,0,16,18,19,24,27,32,38,42,46,54,70,85,115,135,185,225,275,315],[0,0,15,16,17,22,25,28,35,39,42,51,60,80,100,125,170,210,255,290],[0,0,14,15,16,20,25,26,30,34,40,46,50,75,90,115,150,185,225,260],[0,0,15,16,18,23,25,28,32,37,40,48,55,80,100,125,160,195,245,295],[0,0,14,14.5,15,19,21,24,27,31,34,43,50,70,85,100,135,175,215,250]];var Ccca=[[2,2.5,3,4,5,6,8,10,16,25,35,50,70,95,120],[21,24,27,32,36,39,46,60,75,105,130,165,210,255,295],[19,20,24,28,32,36,43,50,60,85,100,140,175,215,245],[18,19,22,28,30,32,40,47,60,80,95,130,165,200,220],[15,19,21,23,27,30,37,39,55,70,85,120,140,175,200],[17,19,22,25,28,31,38,42,60,75,95,125,150,190,230],[14,16,18,21,24,26,32,38,55,65,75,105,135,165,190]];var result=document.getElementById("result");var perVT=document.getElementById("rekVT");var perMP=document.getElementById("rekMP");var perSM=document.getElementById("rekSM");var perSMV=+perSM.value.replace(',',".");var perU=document.getElementById("rekU");var perUV=+perU.value.replace(',',".");var perSE=document.getElementById("rekSE");var perCos=document.getElementById("rekCos");var perCosV=+perCos.value.replace(',',".");var perSP=document.getElementById("rekSP");var perKP=document.getElementById("rekKP");var perDl=document.getElementById("rekDl");var perDlV=+perDl.value.replace(',',".");var perPU=document.getElementById("rekPU");var perPUV=+perPU.value.replace(',',".");if(perVT.options[perVT.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, не выбран вид тока!</span>";return;}
if(perMP.options[perMP.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, не выбран материал проводника!</span>";return;}
if(perSP.options[perSP.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, не выбран способ прокладки!</span>";return;}
if(perKP.options[perKP.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, не выбрано количество проводников!</span>";return;}
if(isNaN(perSMV)){result.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указана мощность!</span>";return;}
if(perSMV<=0){result.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указана мощность!</span>";return;}
if(perSMV>=50){result.innerHTML="<span style='color:red;'>Мощность слишком велика!</span>";return;}
if(isNaN(perUV)){result.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указано напряжение!</span>";return;}
if(perUV<=0){result.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указано напряжение!</span>";return;}
if(perVT.options[perVT.selectedIndex].value==1){if(perSE.options[perSE.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, для переменного тока не выбрана система электроснабжения!</span>";return;}}
if(perVT.options[perVT.selectedIndex].value==1){if(isNaN(perCosV)){result.innerHTML="<span style='color:red;'>Не могу рассчитать, для переменного тока не указан коэффициент мощности cos&#966;!</span>";return;}}
if(perVT.options[perVT.selectedIndex].value==1){if(perCosV<=0){result.innerHTML="<span style='color:red;'>Не могу рассчитать, для переменного тока неверно указан коэффициент мощности cos&#966;!</span>";return;}}
if(perVT.options[perVT.selectedIndex].value==1){if(perCosV>1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, для переменного тока неверно указан коэффициент мощности cos&#966;!</span>";return;}}
if(perVT.options[perVT.selectedIndex].value==1){var irasch=(perSMV*1000/(perUV*perCosV*perSE.options[perSE.selectedIndex].value)).toFixed(2);}
else{var irasch=(perSMV*1000/perUV).toFixed(2);}
if(irasch>190){result.innerHTML="<span style='color:red;'>Ток слишком большой, увеличьте напряжение!</span>";return;}
var indMas;var indMasT;indMasT=perSP.options[perSP.selectedIndex].value;if(indMasT==1){indMas=1}
else{indMas=perKP.options[perKP.selectedIndex].value;}
var sech;if(perMP.options[perMP.selectedIndex].value==1){for(var i=0;i<20;i++){if(Cccc[indMas][i]>=irasch){sech=Cccc[0][i];break;}}}
else{for(var i=0;i<15;i++){if(Ccca[indMas][i]>=irasch){sech=Ccca[0][i];break;}}}
result.innerHTML=sech+" кв.мм.";}
function calc1(){var Cccc=[[0.5,0.75,1,1.2,1.5,2,2.5,3,4,5,6,8,10,16,25,35,50,70,95,120],[11,15,17,20,23,26,30,34,41,46,50,62,80,100,140,170,215,270,330,385],[0,0,16,18,19,24,27,32,38,42,46,54,70,85,115,135,185,225,275,315],[0,0,15,16,17,22,25,28,35,39,42,51,60,80,100,125,170,210,255,290],[0,0,14,15,16,20,25,26,30,34,40,46,50,75,90,115,150,185,225,260],[0,0,15,16,18,23,25,28,32,37,40,48,55,80,100,125,160,195,245,295],[0,0,14,14.5,15,19,21,24,27,31,34,43,50,70,85,100,135,175,215,250]];var Ccca=[[2,2.5,3,4,5,6,8,10,16,25,35,50,70,95,120],[21,24,27,32,36,39,46,60,75,105,130,165,210,255,295],[19,20,24,28,32,36,43,50,60,85,100,140,175,215,245],[18,19,22,28,30,32,40,47,60,80,95,130,165,200,220],[15,19,21,23,27,30,37,39,55,70,85,120,140,175,200],[17,19,22,25,28,31,38,42,60,75,95,125,150,190,230],[14,16,18,21,24,26,32,38,55,65,75,105,135,165,190]];var result=document.getElementById("result");var perVT=document.getElementById("rekVT");var perMP=document.getElementById("rekMP");var perSM=document.getElementById("rekSM");var perSMV=+perSM.value.replace(',',".");var perU=document.getElementById("rekU");var perUV=+perU.value.replace(',',".");var perSE=document.getElementById("rekSE");var perCos=document.getElementById("rekCos");var perCosV=+perCos.value.replace(',',".");var perSP=document.getElementById("rekSP");var perKP=document.getElementById("rekKP");var perDl=document.getElementById("rekDl");var perDlV=+perDl.value.replace(',',".");var perPU=document.getElementById("rekPU");var perPUV=+perPU.value.replace(',',".");if(perVT.options[perVT.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, не выбран вид тока!</span>";return;}
if(perMP.options[perMP.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, не выбран материал проводника!</span>";return;}
if(perSP.options[perSP.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, не выбран способ прокладки!</span>";return;}
if(perKP.options[perKP.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, не выбрано количество проводников!</span>";return;}
if(isNaN(perSMV)){result.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указана мощность!</span>";return;}
if(perSMV<=0){result.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указана мощность!</span>";return;}
if(perSMV>=50){result.innerHTML="<span style='color:red;'>Мощность слишком велика!</span>";return;}
if(isNaN(perUV)){result.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указано напряжение!</span>";return;}
if(perUV<=0){result.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указано напряжение!</span>";return;}
if(perVT.options[perVT.selectedIndex].value==1){if(perSE.options[perSE.selectedIndex].value<1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, для переменного тока не выбрана система электроснабжения!</span>";return;}}
if(perVT.options[perVT.selectedIndex].value==1){if(isNaN(perCosV)){result.innerHTML="<span style='color:red;'>Не могу рассчитать, для переменного тока не указан коэффициент мощности cos&#966;!</span>";return;}}
if(perVT.options[perVT.selectedIndex].value==1){if(perCosV<=0){result.innerHTML="<span style='color:red;'>Не могу рассчитать, для переменного тока неверно указан коэффициент мощности cos&#966;!</span>";return;}}
if(perVT.options[perVT.selectedIndex].value==1){if(perCosV>1){result.innerHTML="<span style='color:red;'>Не могу рассчитать, для переменного тока неверно указан коэффициент мощности cos&#966;!</span>";return;}}
var irasch=(perSMV*1000/(perUV*perCosV*perSE.options[perSE.selectedIndex].value)).toFixed(2);if(irasch>190){result.innerHTML="<span style='color:red;'>Ток слишком большой, увеличьте напряжение!</span>";return;}
var indMas;var indMasT;indMasT=perSP.options[perSP.selectedIndex].value;if(indMasT==1){indMas=1}
else{indMas=perKP.options[perKP.selectedIndex].value;}
var sech;if(perMP.options[perMP.selectedIndex].value==1){for(var i=0;i<20;i++){if(Cccc[indMas][i]>=irasch){sech=Cccc[0][i];break;}}}
else{for(var i=0;i<15;i++){if(Ccca[indMas][i]>=irasch){sech=Ccca[0][i];break;}}}
result.innerHTML=sech+" кв.мм.";result1.innerHTML=sech+" кв.мм.";if(isNaN(perDlV)){result1.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указана длина кабеля!</span>";return;}
if(perDlV<=0){result1.innerHTML="<span style='color:red;'>Не могу рассчитать, неверно указана длина кабеля!</span>";return;}
if(perDlV>9999){result1.innerHTML="<span style='color:red;'>Длина кабеля слишком велика!</span>";return;}
if(perMP.options[perMP.selectedIndex].value==1){var udsopr=0.0172;}
else{var udsopr=0.028;}
var osopr=udsopr*perDlV/sech;var pad=osopr*irasch;var sech1=0;if(pad>perUV*perPUV/100)
{if(perMP.options[perMP.selectedIndex].value==1)
{for(var i=0;i<20;i++)
{osopr=udsopr*perDlV/Cccc[0][i];pad=osopr*irasch;if(pad<perUV*perPUV/100){sech1=Cccc[0][i];break;}}
if(sech1==0){result1.innerHTML="<span style='color:red;'>Не удается подобрать сечение. Длина кабеля слишком велика!</span>";}
else{result1.innerHTML=sech1+" кв.мм.";}}
else
{for(var i=0;i<15;i++)
{osopr=udsopr*perDlV/Ccca[0][i];pad=osopr*irasch;if(pad<perUV*perPUV/100){sech1=Ccca[0][i];break;}}
if(sech1==0){result1.innerHTML="<span style='color:red;'>Не удается подобрать сечение. Длина кабеля слишком велика!</span>";}
else{result1.innerHTML=sech1+" кв.мм.";}}}
else
result1.innerHTML=sech+" кв.мм.";}
function ChangeVT(){var perVT=document.getElementById("rekVT");var perCos=document.getElementById("rekCos");var perSE=document.getElementById("rekSE");if(perVT.options[perVT.selectedIndex].value==1){comVT.innerHTML="<span style='color:#008000;'>Переменный ток наиболее широко распространен в быту и промышленности.</span>";perCos.disabled=0;perSE.disabled=0;}
else if(perVT.options[perVT.selectedIndex].value==2){comVT.innerHTML="<span style='color:#008000;'>Постоянный ток широко используется в большинстве электронных схем, при некоторых видах сварочных работ, в автомобильной, мото- и сельскохозяйственной технике. В быту мощные потребители постоянного тока используются редко.</span>";perCos.disabled=1;perSE.disabled=1;}
else{comVT.innerHTML="";perCos.disabled=0;perSE.disabled=0;}}
function ChangeMP(){var perMP=document.getElementById("rekMP");if(perMP.options[perMP.selectedIndex].value==1)
comMP.innerHTML="<span style='color:#008000;'>Медные проводники обладают меньшим удельным сопротивлением и большей надежностью, но имеют более высокую стоимость по сравнению с алюминиевыми.<br/>Согласно ПУЭ 7 в жилых, общественных, административных и бытовых зданий следует применять кабели и провода с медными жилами.</span>";else if(perMP.options[perMP.selectedIndex].value==2)
comMP.innerHTML="<span style='color:#008000;'>Алюминиевые проводники легче и дешевле медных, но обладают более высоким удельным сопротивлением. <br/>Согласно ПУЭ 7 в жилых, общественных, административных и бытовых зданий возможно применение кабелей и проводов с алюминиевыми жилами, если их расчетное сечение не менее 16 кв.мм.</span>";else comMP.innerHTML="";}
function ChangeSM(){var perSM=document.getElementById("rekSM");var perSMV=+perSM.value.replace(',',".");if(!isNaN(perSMV)){if(perSMV<=0)
comSM.innerHTML="<span style='color:red;'>Неверное значение мощности!</span>";else if(perSMV<0.01)
comSM.innerHTML="<span style='color:#008000;'>Монтаж электрических цепей управления, электронных схем.</span>";else if(perSMV<0.1)
comSM.innerHTML="<span style='color:#008000;'>Подключение одиночных маломощных бытовых приборов, светильников с энергосберегающими люминесцентными лампами.</span>";else if(perSMV<0.5)
comSM.innerHTML="<span style='color:#008000;'>Монтаж цепей бытового освещения с лампами накаливания.</span>";else if(perSMV<1)
comSM.innerHTML="<span style='color:#008000;'>Разводка для слабонагруженных одиночных розеток в жилых помещениях, подключение бытового ручного электроинструмента.</span>";else if(perSMV<2)
comSM.innerHTML="<span style='color:#008000;'>Разводка для средненагруженных одиночных розеток в жилых помещениях, подключение бытового или профессионального ручного электроинструмента.</span>";else if(perSMV<3)
comSM.innerHTML="<span style='color:#008000;'>Разводка для сильнонагруженных одиночных розеток в жилых помещениях, подключение профессионального ручного электроинструмента, кухонной и бытовой техники.</span>";else if(perSMV<5)
comSM.innerHTML="<span style='color:#008000;'>Разводка для групп нагруженных розеток в жилых помещениях, одиночных розеток в производственных помещениях, подключение профессионального электроинструмента, мощной кухонной и бытовой техники.</span>";else if(perSMV<10)
comSM.innerHTML="<span style='color:#008000;'>Подключение обогревателей, кондиционеров, водопроводных и канализационных насосов, бытовых дерево- и металлообрабатывающих станков.</span>";else if(perSMV<20)
comSM.innerHTML="<span style='color:#008000;'>Установки электрического отопления, электрические котлы, теплые полы, профессиональные станки.</span>";else if(perSMV<30)
comSM.innerHTML="<span style='color:#008000;'>Подключение высокопроизводительного производственного оборудования.</span>";else if(perSMV<50)
comSM.innerHTML="<span style='color:#008000;'>Подключение комплексов промышленного оборудования.</span>";else if(perSMV>=50)
comSM.innerHTML="<span style='color:#008000;'>Подключение оборудования большой мощности. Требует обеспечения особых требований электро- и пожаробезопасности, не рекомендуется для самостоятельного выполнения без соответствующих специальных знаний.</span>";}
else
comSM.innerHTML="<span style='color:red;'>Неверное значение мощности!</span>";}
function ChangeU(){var perU=document.getElementById("rekU");var perUV=+perU.value.replace(',',".");if(!isNaN(perUV)){if(perUV<0)
comU.innerHTML="<span style='color:red;'>Неверное значение напряжения!</span>";else if(perUV<12)
comU.innerHTML="<span style='color:#008000;'>Безопасное напряжение для помещений с повышенной опасностью.</span>";else if(perUV<36)
comU.innerHTML="<span style='color:#008000;'>Безопасное напряжение для жилых помещений.</span>";else if(perUV<400)
comU.innerHTML="<span style='color:#008000;'>Напряжение бытовой или промышленной электрической сети. При выполнении работ соблюдайте правила электробезопасности.</span>";else if(perUV>400)
comU.innerHTML="<span style='color:#008000;'>Высокое напряжение! Требует обеспечения особых требований электро- и пожаробезопасности, не рекомендуется проектирование и монтаж электроустановок высокого напряжения без соответствующих специальных знаний.</span>";}
else
comU.innerHTML="<span style='color:red;'>Неверное значение напряжения!</span>";}
function ChangeSE(){var perSE=document.getElementById("rekSE");if(perSE.options[perSE.selectedIndex].value==1)
comSE.innerHTML="<span style='color:#008000;'>Однофазная система применяется для подключения оборудования относительно небольшой мощности в квартирах и небольших частных домах. Требует использования трех проводов - фаза, ноль, защитный ноль (A, N, PE).</span>";else if(perSE.options[perSE.selectedIndex].value>1)
comSE.innerHTML="<span style='color:#008000;'>Трехфазная система применяется для подключения трехфазных электродвигателей, оборудования большой мощности в домах и коттеджах, производственных предприятиях. Требует использования пяти проводов - три фазы, ноль, защитный ноль (A, B, C, N, PE).</span>";else comSE.innerHTML="";}
function ChangePU(){var perPU=document.getElementById("rekPU");var perPUV=+perPU.value.replace(',',".");if(!isNaN(perPUV)){if(perPUV<0)
comPU.innerHTML="<span style='color:red;'>Неверное значение падения напряжения!</span>";else if(perPUV>99)
comPU.innerHTML="<span style='color:red;'>Неверное значение падения напряжения!</span>";else
comPU.innerHTML="<span style='color:#008000;'>Падение напряжения в допустимых пределах</span>";}
else
comPU.innerHTML="<span style='color:red;'>Неверное значение падения напряжения!</span>";}
function ChangeCos(){var perCos=document.getElementById("rekCos");var perCosV=+perCos.value.replace(',',".");if(!isNaN(perCosV)){if(perCosV<0)
comCos.innerHTML="<span style='color:red;'>Неверное значение коэффициента мощности!</span>";else if(perCosV>1)
comCos.innerHTML="<span style='color:red;'>Неверное значение коэффициента мощности!</span>";else
comCos.innerHTML="<span style='color:#008000;'>Значение коэффициента мощности в норме. </span>";}
else
comCos.innerHTML="<span style='color:red;'>Неверное значение коэффициента мощности!</span>";}
function ChangeSP(){var perSP=document.getElementById("rekSP");if(perSP.options[perSP.selectedIndex].value==1)
comSP.innerHTML="<span style='color:#008000;'>Открытая проводка выполняется на керамических изоляторах или пластиковых скобах. В домах со стенами из горючих материалов открытая проводка является предпочтительным и широко распространенным способом монтажа электрических сетей.</span>";else if(perSP.options[perSP.selectedIndex].value==2)
comSP.innerHTML="<span style='color:#008000;'>Скрытая проводка выполняется в штробах с последующей заделкой, каналах строительных конструкций, строительных пустотах. Для деревянных зданий скрытая проводка возможна только в металлических трубах или металлорукавах.</span>";else comMP.innerHTML="";}
function ChangeDl(){var perDl=document.getElementById("rekDl");var perDlV=+perDl.value.replace(',',".");if(!isNaN(perDlV)){if(perDlV<=0)
comDl.innerHTML="<span style='color:red;'>Неверное значение длины кабеля!</span>";else if(perDlV>9999)
comDl.innerHTML="<span style='color:red;'>Слишком большая длина кабеля!</span>";else
comDl.innerHTML="Длина кабеля в норме";}
else
comCos.innerHTML="<span style='color:red;'>Неверное значение длины кабеля!</span>";}/*]]>*/</script>
<div>
<p>Калькулятор позволяет рассчитать сечение токоведущих жил электрических проводов и кабелей по электрической мощности.</p><hr/>
<h2><strong>Вид электрического тока</strong></h2>
<p>Вид тока зависит от системы электроснабжения и подключаемого оборудования.</p>
<p><span lang="ru">Выберите вид тока</span>: <select onchange="ChangeVT()"  id="rekVT"><option value="0">Выбрать</option><option value="1">Переменный ток</option><option value="2">Постоянный ток</option> </select><br></p><div><span id="comVT"></span></div><hr/><h2><strong>Материал проводников кабеля</strong></h2><p>Материал проводников определяет технико-экономические показатели кабельной линии.</p><p>Выберите материал проводников:</p> <select onchange="ChangeMP()"  id="rekMP"><option value="0">Выбрать</option><option value="1">Медь (Cu)</option><option value="2">Алюминий (Al)</option> </select><br><div><span id="comMP"></span></div><hr/><h3><strong>Суммарная мощность подключаемой нагрузки</strong></h3><p>Мощность нагрузки для кабеля определяется как сумма потребляемых мощностей всех электроприборов, подключаемых к этому кабелю.</p><p>Введите мощность нагрузки: <input type="text" onchange="ChangeSM()" value="1" id="rekSM" maxLength="3" size="3"> кВт</p><div><span id="comSM"></span></div><hr/><h3><strong>Номинальное напряжение</strong></h3><p>Введите напряжение: <input type="text" onchange="ChangeU()" value="0" id="rekU" maxLength="4" size="3">В</p><div><span id="comU"></span></div><hr/><h3><strong>Только для переменного тока</strong></h3><p>Система электроснабжения: <select onchange="ChangeSE()"  id="rekSE"><option value="0">Выбрать</option><option value="1">Однофазная</option><option value="1.73">Трехфазная</option> </select><br><div><span id="comSE"></span></div><p>Коэффициент мощности cos&#966; <span lang="ru">определяет отношение активной энергии к полной. Для мощных потребителей значение указано в паспорте устройства. Для бытовых потребителей </span>cos&#966;<span lang="ru"> принимают равным 1.</span></p><p>Коэффициент мощности cos&#966;: <input type="text" onchange="ChangeCos()" value="1" id="rekCos" maxLength="54" size="4"></p><div><span id="comCos"></span></div><hr/><h3><strong>Способ прокладки кабеля</strong></h3><p>Способ прокладки определяет условия теплоотвода и влияет на максимальную допустимую нагрузку на кабель.</p><p>Выберите способ прокладки:</p> <select onchange="ChangeSP()"  id="rekSP"><option value="0">Выбрать</option><option value="1">Открытая проводка</option><option value="2">Скрытая проводка</option> </select><br><div><span id="comSP"></span></div><hr/><h3><strong>Количество нагруженных проводов в пучке</strong></h3><p>Для постоянного тока нагруженными считаются все провода, для переменного <span style="white-space:nowrap">однофазного —</span> фазный и нулевой, для переменного <span style="white-space:nowrap">трехфазного —</span> только фазные.</p><p>Выберите количество проводов:</p> <select onchange="ChangeKP()" id="rekKP"><option value="0">Выбрать</option><option value="2">Два провода в раздельной изоляции</option><option value="3">Три провода в раздельной изоляции</option><option value="4">Четыре провода в раздельной изоляции</option><option value="5">Два провода в общей изоляции</option><option value="6">Три провода в общей изоляции</option> </select><br><div><span id="comKP"></span></div><hr/><div style="text-align:center;"><input type="button" id="count" value="Рассчитать" onclick="calc()"></div> <br/><div style="font-weight: bold; margin: 0 0 20px 0;">Минимальное сечение кабеля: <span id="result">0</span></div><p>Кабель с рассчитанным сечением не будет перегреваться при заданной нагрузке. Для окончательного выбора сечения кабеля необходимо проверить падение напряжения на токонесущих жилах кабельной линии.</p><p> </p><h3><strong>Длина кабеля</strong></h3><p>Введите длину кабеля: <input type="text" onchange="ChangeDl()" value="1" id="rekDl" maxLength="4" size="3">м</p><div><span id="comDl"></span></div><hr/><h3><strong>Допустимое падение напряжения на нагрузке</strong></h3><p>Введите допустимое падение: <input type="text" onchange="ChangePU()" value="5" id="rekPU" maxLength="2" size="3">%</p><div><span id="comPU"></span></div><hr/><div style="text-align:center;"><input type="button" id="count" value="Рассчитать" onclick="calc1()"></div><div style="font-weight: bold; margin: 0 0 20px 0;"><br>Минимальное сечение кабеля с учетом длины: <span id="result1">0</span></div><p><span style="color:#FF0000;">Рассчитанное значение сечения кабеля является ориентировочным и не может использоваться в проектах систем электроснабжения без профессиональной оценки и обоснования в соответствии с нормативными документами!</span>
		</div>
	</div></div>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
   <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
