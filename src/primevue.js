import 'primevue/resources/primevue.min.css';
import 'primeflex/primeflex.css';
import 'primeicons/primeicons.css';
import 'prismjs/themes/prism-coy.css';

import PrimeVue from 'primevue/config';
import Ripple from 'primevue/ripple';
import StyleClass from 'primevue/styleclass';
import BadgeDirective from 'primevue/badgedirective';

globalApp.app.use(PrimeVue, { ripple: true, inputStyle: 'outlined' });

globalApp.app.directive('ripple', Ripple);
globalApp.app.directive('styleclass', StyleClass);
globalApp.app.directive('badge', BadgeDirective);

/********************* PrimeVue Region *******************/
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';
import ConfirmDialog from 'primevue/confirmdialog';
import Textarea from 'primevue/textarea';
import Menu from 'primevue/menu';
import MultiSelect from 'primevue/multiselect';
import Fieldset from 'primevue/fieldset';
import Checkbox from 'primevue/checkbox';
import TreeSelect from 'primevue/treeselect';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import Dialog from 'primevue/dialog';
import Menubar from 'primevue/menubar';
import TabMenu from 'primevue/tabmenu';
import InputSwitch from 'primevue/inputswitch';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Password from 'primevue/password';
import ProgressSpinner from 'primevue/progressspinner';
import Dropdown from 'primevue/dropdown';
import Card from 'primevue/card';
import Calendar from 'primevue/calendar';
import Message from 'primevue/message';
import FileUpload from 'primevue/fileupload';
import Splitter from 'primevue/splitter';
import SplitterPanel from 'primevue/splitterpanel';
import ScrollPanel from 'primevue/scrollpanel';
import ScrollTop from 'primevue/scrolltop';
import DataView from 'primevue/dataview';
import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions';
import Listbox from 'primevue/listbox';
import Toast from 'primevue/toast';
import Breadcrumb from 'primevue/breadcrumb';

globalApp.app.component('Breadcrumb', Breadcrumb);
globalApp.app.component('Toast', Toast);
globalApp.app.component('Listbox', Listbox);
globalApp.app.component('DataView', DataView);
globalApp.app.component('DataViewLayoutOptions', DataViewLayoutOptions);
globalApp.app.component('ScrollTop', ScrollTop);
globalApp.app.component('Button', Button);
globalApp.app.component('DataTable', DataTable);
globalApp.app.component('Column', Column);
globalApp.app.component('InputText', InputText);
globalApp.app.component('Toolbar', Toolbar);
globalApp.app.component('ConfirmDialog', ConfirmDialog);
globalApp.app.component('Textarea', Textarea);
globalApp.app.component('Menu', Menu);
globalApp.app.component('MultiSelect', MultiSelect);
globalApp.app.component('Fieldset', Fieldset);
globalApp.app.component('Checkbox', Checkbox);
globalApp.app.component('TreeSelect', TreeSelect);
globalApp.app.component('Accordion', Accordion);
globalApp.app.component('AccordionTab', AccordionTab);
globalApp.app.component('Dialog', Dialog);
globalApp.app.component('Menubar', Menubar);
globalApp.app.component('TabMenu', TabMenu);
globalApp.app.component('InputSwitch', InputSwitch);
globalApp.app.component('TabView', TabView);
globalApp.app.component('TabPanel', TabPanel);
globalApp.app.component('Password', Password);
globalApp.app.component('ProgressSpinner', ProgressSpinner);
globalApp.app.component('Dropdown', Dropdown);
globalApp.app.component('Card', Card);
globalApp.app.component('Calendar', Calendar);
globalApp.app.component('Message', Message);
globalApp.app.component('FileUpload', FileUpload);
globalApp.app.component('Splitter', Splitter);
globalApp.app.component('SplitterPanel', SplitterPanel);
globalApp.app.component('ScrollPanel', ScrollPanel);

/********************* Custome Components Region *******************/

// import Loader from '@/components/Loader.vue';
// import SearchButton from '@/components/Buttons/Search.vue';
// import BackButton from '@/components/Buttons/Back.vue';
// import SysDatatable from '@/components/SysDatatable.vue';

// globalApp.app.component('Loader', Loader);
// globalApp.app.component('SysDatatable', SysDatatable);
// globalApp.app.component('SearchButton', SearchButton);
// globalApp.app.component('BackButton', BackButton);

// import AutoComplete from 'primevue/autocomplete';
// import Avatar from 'primevue/avatar';
// import AvatarGroup from 'primevue/avatargroup';
// import Badge from 'primevue/badge';

// 
//
// import Carousel from 'primevue/carousel';
// import Chart from 'primevue/chart';
// 
// import Chip from 'primevue/chip';
// import Chips from 'primevue/chips';
// import ColorPicker from 'primevue/colorpicker';
//
// 
// import ConfirmPopup from 'primevue/confirmpopup';
// import ContextMenu from 'primevue/contextmenu';
 
// import DataView from 'primevue/dataview';
// import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions';
//
// import Divider from 'primevue/divider';
// 
// import FileUpload from 'primevue/fileupload';
// import InlineMessage from 'primevue/inlinemessage';
// import Inplace from 'primevue/inplace';
// import InputMask from 'primevue/inputmask';
// import InputNumber from 'primevue/inputnumber';
//
//
// import Knob from 'primevue/knob';
// import Galleria from 'primevue/galleria';

// import MegaMenu from 'primevue/megamenu';
// 
//
// 
// 
// import OrderList from 'primevue/orderlist';
// import OrganizationChart from 'primevue/organizationchart';
// import OverlayPanel from 'primevue/overlaypanel';
// import Paginator from 'primevue/paginator';
// import Panel from 'primevue/panel';
// import PanelMenu from 'primevue/panelmenu';
// import PickList from 'primevue/picklist';
// import ProgressBar from 'primevue/progressbar';
// import Rating from 'primevue/rating';
// import RadioButton from 'primevue/radiobutton';
// 
// import ScrollPanel from 'primevue/scrollpanel';

// import Slider from 'primevue/slider';
// import Sidebar from 'primevue/sidebar';
// import Skeleton from 'primevue/skeleton';
// import SplitButton from 'primevue/splitbutton';

// import Steps from 'primevue/steps';
 
// import Tag from 'primevue/tag';
// import TieredMenu from 'primevue/tieredmenu';
// 
// import Timeline from 'primevue/timeline';
// 
// 
// 
// 
// import ToggleButton from 'primevue/togglebutton';
// import Tree from 'primevue/tree';
// import TreeTable from 'primevue/treetable';
// import TriStateCheckbox from 'primevue/tristatecheckbox';



// app.component('AutoComplete', AutoComplete);
// app.component('Avatar', Avatar);
// app.component('AvatarGroup', AvatarGroup);
// app.component('Badge', Badge);
// app.component('Breadcrumb', Breadcrumb);
 
// app.component('Calendar', Calendar);
// app.component('Card', Card);
// app.component('Carousel', Carousel);
// app.component('Chart', Chart);
// 
// app.component('Chip', Chip);
// app.component('Chips', Chips);
// app.component('ColorPicker', ColorPicker);
//
// 
// app.component('ConfirmPopup', ConfirmPopup);
// app.component('ContextMenu', ContextMenu);
// 
// app.component('DataView', DataView);
// app.component('DataViewLayoutOptions', DataViewLayoutOptions);
// app.component('Divider', Divider);
// app.component('Dropdown', Dropdown);
// 
// app.component('FileUpload', FileUpload);
// app.component('InlineMessage', InlineMessage);
// app.component('Inplace', Inplace);
// app.component('InputMask', InputMask);
// app.component('InputNumber', InputNumber);
// 
// app.component('Galleria', Galleria);
// app.component('Knob', Knob);
// app.component('Listbox', Listbox);
// app.component('MegaMenu', MegaMenu);
// 
// app.component('Menubar', Menubar);
// app.component('Message', Message);
// 
// app.component('OrderList', OrderList);
// app.component('OrganizationChart', OrganizationChart);
// app.component('OverlayPanel', OverlayPanel);
// app.component('Paginator', Paginator);
// app.component('Panel', Panel);
// app.component('PanelMenu', PanelMenu);
// app.component('PickList', PickList);
// app.component('ProgressBar', ProgressBar);
// app.component('RadioButton', RadioButton);
// app.component('Rating', Rating);
// app.component('SelectButton', SelectButton);
// app.component('ScrollPanel', ScrollPanel);
// app.component('ScrollTop', ScrollTop);
// app.component('Slider', Slider);
// app.component('Sidebar', Sidebar);
// app.component('Skeleton', Skeleton);
// app.component('SplitButton', SplitButton);

// app.component('Steps', Steps);

// app.component('Tag', Tag);
// 
// app.component('TieredMenu', TieredMenu);
// app.component('Timeline', Timeline);
// 
// 
// app.component('ToggleButton', ToggleButton);
// app.component('Tree', Tree);
// app.component('TreeTable', TreeTable);
// app.component('TriStateCheckbox', TriStateCheckbox);

// export default app;