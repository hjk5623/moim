package chapter05.exercise6;

public class RectangleExecute {

	public static void main(String[] args) {
		Rectangle rectangle=new Rectangle();
		rectangle.setWidth(5);
		rectangle.setHeight(6);
		
		System.out.println("가로:"+ rectangle.getWidth());
		System.out.println("세로: "+ rectangle.getHeight());
		System.out.println("면적: "+ rectangle.calArea());
		System.out.println("둘레: "+ rectangle.calPerimeter());
		System.out.println(rectangle);
	}

}
